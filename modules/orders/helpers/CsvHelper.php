<?php
namespace app\modules\orders\helpers;

use Yii;
use yii\db\Query;


/**
 * Helper for save csv orders in file
 */
class CsvHelper {

    /**
     * Create csv file in web/upload/csv
     *
     * @param Query $query
     * @return void
     */
    public static function saveToCsvFile($query) {
        ob_start();
        $fh = fopen('file.csv', 'w');
        fputcsv($fh, [
            Yii::t('app', 'orders.orders.id'),
            Yii::t('app', 'orders.orders.user'),
            Yii::t('app', 'orders.orders.link'),
            Yii::t('app', 'orders.orders.quantity'),
            Yii::t('app', 'orders.orders.service'),
            Yii::t('app', 'orders.orders.status'),
            Yii::t('app', 'orders.orders.mode'),
            Yii::t('app', 'orders.orders.created')
        ], "\t");
        fclose($fh);
        $fh = fopen('file.csv', 'a');
        foreach ($query->each() as $row) {
            fputcsv($fh, [
                $row['id'], $row['user'], $row['link'], $row['quantity'],
                $row['service_name'], $row['status'], $row['mode'],
                date('Y-m-d H:i:s', intval($row['created_at']))
            ], "\t");
        }
        fclose($fh);
        ob_end_clean();
    }

}
