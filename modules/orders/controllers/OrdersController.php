<?php

namespace app\modules\orders\controllers;

use app\modules\orders\helpers\ServicesHelper;
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
        $model = new OrdersSearch();
        $query = $model->filter(Yii::$app->request->get());
        //\yii\helpers\VarDumper::dump(Yii::$app->request->get());die;
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => Yii::$app->params['orders_page_size']]);
        $orders = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        //$services = ServicesHelper::getRestServices($query);
        return $this->render('index', [
            'orders' => $orders,
            'pages' => $pages,
            //'services' => $services
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
