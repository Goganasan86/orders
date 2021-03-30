<?php
namespace app\modules\orders\helpers;

//set_time_limit ( 0 );

use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii2tech\csvgrid\CsvGrid;
use yii\db\BatchQueryResult;

/**
 * Helper for save csv orders in file
 */
class CsvHelper {

    /**
     * Create csv file in web/upload/csv
     *
     * @param Query $query
     * @return void
     * @throws \yii\base\InvalidConfigException
     */
    public static function saveToCsv($query) {

        foreach ($query->each() as $row) {
            //var_dump($row);die;
            $fh = fopen('file.csv', 'w');

            fputcsv($fh, $row, "\t");

            fclose($fh);
        }

    }

}
