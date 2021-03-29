<?php

namespace app\modules\orders\controllers;

use app\modules\orders\helpers\CsvHelper;
use app\modules\orders\helpers\ServicesHelper;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\web\Controller;
use app\modules\orders\models\search\OrdersSearch;
use Yii;

/**
 * Default controller for the `orders` module
 */
class OrdersController extends Controller
{
    /**
     * Error handle
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = new OrdersSearch();
        /** @var ActiveQuery $query */
        $query = $model->filter(Yii::$app->request->get());
        $services = ServicesHelper::getServices(clone $query);
        //var_dump($query);die;
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => Yii::$app->params['orders_page_size']]);
        $orders = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'orders' => $orders,
            'pages' => $pages,
            'services' => $services,
        ]);
    }

    /**
     * Export to csv filtering data
     * @return mixed
     */
    public function actionExportCsv()
    {
        $model = new OrdersSearch();
        /** @var ActiveQuery $query */

        $query = $model->filter(Yii::$app->request->get('params') ?? [])->asArray()->all();
        CsvHelper::seveToCsv($query);
        if (file_exists('upload/csv/orders.csv')) {
            return Yii::$app->response->sendFile('upload/csv/orders.csv', 'orders.csv');
        }
        return Yii::$app->session->setFlash('warning', 'Error then generate CSV');
    }

    /**
     * If error then inmport data to db frof .sql file, you can use this action
     * @return void
     */
    public function actionAddDataToDb()
    {
        $sql = file_get_contents('test_db_data.sql');
        Yii::$app->db->createCommand($sql)->execute();
        var_dump(
            Yii::$app->db->createCommand('select * from orders')->queryAll()
        );
    }
}
