<?php
namespace app\modules\orders\helpers;
use yii\db\ActiveQuery;

/**
 * Helper count services by id
 */

class ServicesHelper {

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
