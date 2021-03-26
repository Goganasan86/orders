<?php
namespace app\modules\orders\helpers;
use yii\db\ActiveQuery;

/**
 * Helper count services by id
 */

class ServicesHelper {

//    public static function getServices() {
//        $sql = ' SELECT DISTINCT o.service_id, s.name, count(o.service_id) as cnt
//                    FROM orders o JOIN services s ON o.service_id = s.id
//                    GROUP BY service_id
//                    ORDER BY cnt DESC ';
//        return Yii::$app->db->createCommand($sql)->queryAll();
//    }
    /**
     * Forming array with services
     *
     * @param ActiveQuery
     *
     * @return array
     */
    public static function getServices($query) {
        $ordersArray = $query->with('services')->asArray()->all();
        $servicesID = Array();
        foreach ($ordersArray as $order) {
            $servicesID[] = $order['services'];
        }

        $sortServicesId = array_count_values(array_map(function($item) {
            return $item['id'];
        }, $servicesID));

        arsort($sortServicesId);

        return $sortServicesId;
    }
}
