<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicle".
 *
 * @property int $id
 * @property int $model_id
 * @property int $energy_id
 * @property int|null $year
 * @property string|null $description
 * @property int|null $stock
 *
 * @property Orderline[] $orderlines
 * @property Model $model
 * @property Energy $energy
 */
class AbstractVehicle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model_id', 'energy_id'], 'required'],
            [['model_id', 'energy_id', 'year', 'stock'], 'integer'],
            [['description'], 'string'],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => Model::className(), 'targetAttribute' => ['model_id' => 'id']],
            [['energy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Energy::className(), 'targetAttribute' => ['energy_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_id' => 'Model ID',
            'energy_id' => 'Energy ID',
            'year' => 'Year',
            'description' => 'Description',
            'stock' => 'Stock',
        ];
    }

    /**
     * Gets query for [[Orderlines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderlines()
    {
        return $this->hasMany(Orderline::className(), ['vehicle_id' => 'id']);
    }

    /**
     * Gets query for [[Model]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(Model::className(), ['id' => 'model_id']);
    }

    /**
     * Gets query for [[Energy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEnergy()
    {
        return $this->hasOne(Energy::className(), ['id' => 'energy_id']);
    }
}
