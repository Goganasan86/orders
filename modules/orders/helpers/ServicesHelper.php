<?php
namespace app\modules\orders\helpers;

use app\modules\orders\models\Orders;
use app\modules\orders\models\Services;
use phpDocumentor\Reflection\Types\Object_;
use Yii;
use yii\db\ActiveQuery;

class ServicesHelper {

    public static function getServices() {
        $sql = ' SELECT DISTINCT o.service_id, s.name, count(o.service_id) as cnt 
                    FROM orders o JOIN services s ON o.service_id = s.id
                    GROUP BY service_id 
                    ORDER BY cnt DESC ';
        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    public static function getRestServices(ActiveQuery $query) {


        return $query->select('service_id')->groupBy('service_id');

    }
}
