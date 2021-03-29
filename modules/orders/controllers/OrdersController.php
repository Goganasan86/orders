<?php

namespace app\modules\orders\controllers;

use app\modules\orders\helpers\CsvHelper;
use app\modules\orders\helpers\ServicesHelper;
use app\modules\orders\models\Services;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\web\Controller;
use app\modules\orders\models\search\OrdersSearch;
use yii\helpers\ArrayHelper;
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
        /** @var ActiveQuery $query */
        $query = $model->filter(Yii::$app->request->get());
        $services = ServicesHelper::getServices(clone $query);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => Yii::$app->params['orders_page_size']]);
        $orders = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $servicesNames = Services::find()->asArray()->all();
        return $this->render('index', [
            'orders' => $orders,
            'pages' => $pages,
            'servicesId' => $services,
            'servicesNames' => ArrayHelper::map($servicesNames, 'id', 'name'),//TODO делал в спешке, передалать нужно при возможности
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
