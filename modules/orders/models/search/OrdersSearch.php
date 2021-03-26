<?php

namespace app\modules\orders\models\search;

use app\modules\orders\models\Orders;

/**
 * OrdersSearch represents the model behind the search form of `app\modules\orders\models\Orders`.
 */
class OrdersSearch extends Orders
{
    const ID_SEARCH = 1;
    const LINK_SEARCH = 2;
    const USERNAME_SEARCH = 3;


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return array
     */
    public function search($params)
    {
        $query = Orders::find()->orderBy(['id' => SORT_DESC]);
        if (isset($params['search-type'])) {
            if ($params['search-type'] === strval(self::ID_SEARCH)) {
                $query->filterWhere(['id' => $params['search']]);
            }
            if ($params['search-type'] === strval(self::LINK_SEARCH)) {
                $query->filterWhere(['like', 'link', (string)$params['search']]);
            }
            if ($params['search-type'] === strval(self::USERNAME_SEARCH)) {
                $query->select('orders.*')
                    ->joinWith('users')
                    ->filterWhere(['or',
                        ['like', 'users.first_name', (string)$params['search']],
                        ['like', 'users.last_name', (string)$params['search']],
                    ])
                    ->all();
            }
        }

        return $query;
    }

    /**
     * Filtering data
     *
     * @param array $params
     *
     * @return array
     */
    public function filter(array $params)
    {
        $filteringOrders = $this->search($params);
        if (isset($params['status'])) {
            $filteringOrders->andFilterWhere(['status' => $params['status']]);
        }
        if (isset($params['mode'])) {
            $filteringOrders->andFilterWhere(['mode' => $params['mode']]);
        }
        if (isset($params['service'])) {
            $filteringOrders->andFilterWhere(['service_id' => $params['service']]);
        }

        return $filteringOrders;
    }
}
