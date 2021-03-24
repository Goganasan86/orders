<?php

namespace app\modules\orders\models;


use Yii;
use app\modules\orders\models\Users;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $user_id
 * @property string $link
 * @property int $quantity
 * @property int $service_id
 * @property int $status 0 - Pending, 1 - In progress, 2 - Completed, 3 - Canceled, 4 - Fail
 * @property int $created_at
 * @property int $mode 0 - Manual, 1 - Auto
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'link', 'quantity', 'service_id', 'status', 'created_at', 'mode'], 'required'],
            [['id', 'user_id', 'quantity', 'service_id', 'status', 'created_at', 'mode'], 'integer'],
            [['link'], 'string', 'max' => 300],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'link' => Yii::t('app', 'Link'),
            'quantity' => Yii::t('app', 'Quantity'),
            'service_id' => Yii::t('app', 'Service ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'mode' => Yii::t('app', 'Mode'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getUsers()
    {
        return $this->hasOne(Users::class ,['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function getServices()
    {
        return $this->hasOne(Services::class ,['id' => 'service_id']);
    }
}