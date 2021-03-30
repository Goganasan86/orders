<?php

namespace app\modules\orders\controllers;

use app\modules\orders\helpers\CsvHelper;
use app\modules\orders\helpers\ServicesHelper;
use yii\db\ActiveQuery;
use yii\web\Controller;
use app\modules\orders\models\search\OrdersSearch;
use Yii;
use yii\web\HttpException;

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
        $services = ServicesHelper::getServices($query['services']);
//echo '<pre>'; var_dump($query); die;
        return $this->render('index', [
            'orders' => $query['data'],
            'pages' => $query['pages'],
            'services' => $services,
        ]);
    }

    /**
     * Export to csv filtering data
     * @return mixed
     * @throws HttpException
     */
    public function actionExportCsv()
    {
        $model = new OrdersSearch();
        /** @var ActiveQuery $query */

        $query = $model->filter(Yii::$app->request->get('params') ?? [])['data']->all();
        CsvHelper::seveToCsv($query);
        if (file_exists('upload/csv/orders.csv')) {
            return Yii::$app->response->sendFile('upload/csv/orders.csv', 'orders.csv');
        }
        return Yii::$app->session->setFlash('warning', 'Error then generate CSV');
    }
}
