<?php
namespace app\modules\orders\helpers;

/**
 * Helper count services by id
 */
class ServicesHelper {

    /**
     * Forming array with services
     *
     * @param array $services
     *
     * @return array
     */
    public static function getServices($services)
    {
        return array_map(function ($item) {
            return [
                'cnt' => $item['cnt'],
                'id' => $item['service_id'],
                'name' => $item['name']
            ];
        }, $services);
    }


    /**
     * Forming array with services
     *
     * @param array $services
     * @param int $id
     * @return array
     */
    public static function getServicesCount($services, $id)
    {
        return $services[array_search($id, array_column($services, 'service_id'))]['cnt'];
    }

}
