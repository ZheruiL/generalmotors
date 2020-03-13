<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orderline".
 *
 * @property int $id
 * @property int|null $order_id
 * @property int|null $vehicle_id
 * @property string|null $description
 * @property int $qty
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Order $order
 * @property Vehicle $vehicle
 */
class AbstractOrderline extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orderline';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'vehicle_id', 'qty', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['qty'], 'required'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['vehicle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehicle::className(), 'targetAttribute' => ['vehicle_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'vehicle_id' => 'Vehicle ID',
            'description' => 'Description',
            'qty' => 'Qty',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * Gets query for [[Vehicle]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVehicle()
    {
        return $this->hasOne(Vehicle::className(), ['id' => 'vehicle_id']);
    }
}
