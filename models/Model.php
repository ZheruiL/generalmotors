<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "model".
 *
 * @property int $id
 * @property string $name
 * @property int $make_id
 *
 * @property Make $make
 * @property Vehicle[] $vehicles
 */
class Model extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'model';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'make_id'], 'required'],
            [['make_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['make_id'], 'exist', 'skipOnError' => true, 'targetClass' => Make::className(), 'targetAttribute' => ['make_id' => 'id']],
        ];
    }

    public function fields()
    {
        return [
          'id',
          'name',
          'make'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'make_id' => 'Make ID',
        ];
    }

    /**
     * Gets query for [[Make]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMake()
    {
        return $this->hasOne(Make::className(), ['id' => 'make_id']);
    }

    /**
     * Gets query for [[Vehicles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVehicles()
    {
        return $this->hasMany(Vehicle::className(), ['model_id' => 'id']);
    }
}
