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
    public static function getServices($query)
    {
        $services = $query->select(['orders.service_id', "COUNT('orders.service_id') as cnt", 'services.*'])
            ->distinct('orders.service_id')
            ->groupBy('orders.service_id')
            ->orderBy(['cnt' => SORT_DESC])
            ->asArray()->all();

        return array_map(function ($item) {
            return [
                'cnt' => $item['cnt'],
                'id' => $item['id'],
                'name' => $item['name']
            ];
        }, $services);
    }
}
