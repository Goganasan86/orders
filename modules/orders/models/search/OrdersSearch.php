<?php

namespace app\modules\orders\models\search;

use app\modules\orders\models\Orders;
use yii\data\Pagination;
use Yii;
use yii\db\Query;
use yii\web\HttpException;

/**
 * OrdersSearch represents the model behind the search form of `app\modules\orders\models\Orders`.
 */
class OrdersSearch extends Orders
{
    public const ID_SEARCH = 1;
    public const LINK_SEARCH = 2;
    public const USERNAME_SEARCH = 3;

    public $status;
    public $mode;
    public $serviceId;
    public $search;
    public $searchType;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['status', 'number', 'min' => 0, 'max' => 4],
            ['mode', 'number', 'min' => 0, 'max' => 1],
            ['serviceId', 'number'],
            ['search', 'string'],
            ['searchType', 'number', 'min' => 1, 'max' => 3]
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return Query
     */
    public function search()
    {

        $query = new Query();
        $query->select(['orders.id', 'orders.user_id', 'orders.link', 'orders.quantity',
                      'orders.service_id', 'orders.status', 'orders.link', 'orders.mode',
                      'orders.created_at', 'services.name as service_name',
                      'concat(users.first_name," ",users.last_name) as user'])
            ->from('orders')
            ->leftJoin('services', 'orders.service_id = services.id ')
            ->leftJoin('users', 'orders.user_id = users.id ')
            ->orderBy(['orders.id' => SORT_DESC]);

        if (isset($this->searchType)) {
            if ($this->searchType === strval(self::ID_SEARCH)) {
                $query->filterWhere(['orders.id' => $this->search]);
            }
            if ($this->searchType === strval(self::LINK_SEARCH)) {
                $query->filterWhere(['like', 'link', (string)$this->search]);
            }
            if ($this->searchType === strval(self::USERNAME_SEARCH)) {
                $query->filterWhere(['or',
                        ['like', 'users.first_name', (string)$this->search],
                        ['like', 'users.last_name', (string)$this->search],
                ]);
            }
        }
        return $query;
    }

    /**
     * Filtering data
     *
     * @param array $params
     *
     * @return Query
     * @throws HttpException
     */
    public function filter()
    {
        if (!$this->validate()) {
            throw new HttpException(505, 'You write wrong params! Please use form');
        }
        $query = $this->search();
        if (isset($this->status)) {
            $query->andFilterWhere(['status' => $this->status]);
        }
        if (isset($this->mode)) {
            $query->andFilterWhere(['mode' => $this->mode]);
        }
        if (isset($this->serviceId)) {
            $query->andFilterWhere(['service_id' => $this->serviceId]);
        }

        return $query;
    }

    /**
     * Set params and return Query
     *
     * @param array $params
     *
     * @return Query
     * @throws HttpException
     */
    public function getFilteringData($params)
    {
        $this->setParams($params);
        return $this->filter();
    }

    /**
     * Return array with sorted and counted services
     *
     * @param array $params
     *
     * @return array
     * @throws HttpException
     */
    public function getPreparedData($params)
    {
        $filteringOrders = $this->getFilteringData($params);
        $services = $this->countServices(clone $filteringOrders);
        $pages = new Pagination(['totalCount' => $filteringOrders->count(), 'pageSize' => Yii::$app->params['orders_page_size']]);
        return [
            'data' => $this->formatOutput($filteringOrders->offset($pages->offset)->limit($pages->limit)->all()),
            'pages' => $pages,
            'services' => $services
        ];
    }

    /**
     * Return array with sorted and counted services
     *
     * @param Query $query
     *
     * @return array
     */
    public function countServices($query)
    {
         return $query->select(['orders.service_id', "count('orders.service_id') as cnt", 'services.name'])
             ->groupBy('orders.service_id')
             ->orderBy(['cnt' => SORT_DESC])
             ->all();
    }

    /**
     * Return array with sorted and counted services
     *
     * @param array $data
     *
     * @return array
     */
    public function formatOutput($data)
    {
        foreach ($data as &$order) {
            $order['created_date'] = Yii::$app->formatter->asDate($order['created_at'], 'yyyy-mm-dd');
            $order['created_time'] = Yii::$app->formatter->asTime($order['created_at']);
        }
        return $data;
    }

    /**
     * Params setter
     *
     * @param array $params
     *
     * @return void
     */
    public function setParams($params)
    {
        $this->status = $params['status'] ?? null;
        $this->mode = $params['mode'] ?? null;
        $this->serviceId = $params['service'] ?? null;
        $this->search = $params['search'] ?? null;
        $this->searchType = $params['search-type'] ?? null;
    }
}
