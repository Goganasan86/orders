<?php

namespace app\modules\orders\controllers;

use app\modules\orders\models\Orders;
use app\modules\orders\models\Services;
use yii\data\Pagination;
use yii\web\Controller;
use app\modules\orders\models\search\OrdersSearch;
use Yii;

/**
 * Default controller for the `orders` module
 */
class OrdersController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $getData = Yii::$app->request->get();
        $testData = [
            'status' => $getData['status'] ?? '',
            'mode' => $getData['mode'] ?? '',
            'service' => $getData['service'] ?? '',
            'search' => 'Sonny',
            'search-type' => 3,
        ];
        $model = new OrdersSearch();
        $query = $model->filter($testData);

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 100]);
        //echo '<pre>'; var_dump($pages->getPageSize());die;
        $orders = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'orders' => $orders,
            'pages' => $pages,
            'services' => Services::find()->asArray()->all()
        ]);
    }


    /**
     * test
     */
    public function actionTest()
    {
        $sql = file_get_contents('test_db_data.sql');
        Yii::$app->db->createCommand($sql)->execute();
        var_dump(
            Yii::$app->db->createCommand('select * from orders')->queryAll()
        );
    }
}
