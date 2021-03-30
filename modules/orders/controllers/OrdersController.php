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
     * @throws HttpException
     */
    public function actionIndex()
    {
        $model = new OrdersSearch();
        /** @var Query $query */
        $query = $model->getPreparedData(Yii::$app->request->get());
        $services = ServicesHelper::getServices($query['services']);

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
        /** @var Query $query */
        $params = Yii::$app->request->get('params');
        $query = $model->getFilteringData($params);
        return CsvHelper::saveToCsv($query);
    }
}
