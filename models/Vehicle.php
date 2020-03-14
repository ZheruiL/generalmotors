<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class Vehicle extends AbstractVehicle
{
    public function fields()
    {
        return [
            'id',
            'model_id',
            'model',
            /*'make'=>function($model){
                return $model->model->make;
            },*/
            'energy_id',
            'energy',
            'year',
            'stock'
        ];
    }

    public function extraFields()
    {
        return [
            'description'
        ];
    }

    public function saveVehicle($params)
    {
        $this->load($params, '');
        $qty = $this->stock;
        $this->stock=0;
        $stock = $this->increaseStock($qty);
        if($stock->hasErrors()){
            return $stock;
        }
        $this->save();
        return $this;
    }
    public function increaseStock($qty){
        return $this->changeStock($qty);
    }
    public function minusStock($qty){
        return $this->changeStock(-$qty);
    }
    protected function changeStock($qty){
        if($qty===0){
            $this->addError('stock','the qty can not be 0');
            return $this;
        }

        $this->stock+=$qty;
        if($this->stock<=0){
            $this->addError('stock','the stock can not be less than 0');
            return $this;
        }
        //the stock can not pass 100
        //not good to do so, better create a table warehouse to record this
        $vehicles = Vehicle::find()->where(['>', 'stock', 0])->all();
        $totalStock = 0;
        foreach ($vehicles as $vehicle){
            $totalStock += $vehicle->stock;
        }
        $totalStock+=$qty;
        if($totalStock >= 100){
            $this->addError('stock','the total stock can not be more than 100');
            return $this;
        }
        $this->save();
        if($this->stock<=10){
            //todo alert
        }
        return $this;
    }
}
