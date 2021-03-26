<?php
namespace app\modules\orders\helpers;

set_time_limit ( 0 );

use yii\data\ArrayDataProvider;
use yii2tech\csvgrid\CsvGrid;

/**
 * Helper for save csv orders in file
 */
class CsvHelper {

    /**
     * Create csv file in web/upload/csv
     *
     * @param array $params
     *
     * @return void
     */
    public static function seveToCsv($data) {
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);

        $exporter = new CsvGrid([
            'dataProvider' => $dataProvider,
            'columns' => [                     //TODO get from provider this headers
                'id',
                'user_id',
                'link',
                'quantity',
                'service_id',
                'status',
                'mode',
                'created_at',
            ],
        ]);

        $exporter->export()->saveAs('upload/csv/orders.csv');
    }
}
