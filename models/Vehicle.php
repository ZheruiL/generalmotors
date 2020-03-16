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

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['stock', function($attribute){
            if($this->$attribute < 0){
                $this->addError('stock','the stock can not be less than 0');
            }
            if($this->$attribute <= 10){
                //todo alert
            }
            $this->id===null?$id=0:$id=$this->id;
            //the stock can not pass 100
            //not good to do so, better create a table warehouse to record this
            $totalStock = Vehicle::find()
                ->where(['>', 'stock', 0])
                ->where(['<>', 'id', $id])
                ->sum('stock');
            $totalStock = $this->$attribute + intval($totalStock);
            if($totalStock > 100){
                $this->addError('stock','the total stock can not be more than 100');
                return $this;
            }
        }];
        return $rules;
    }

    public function increaseStock($qty){
        return $this->changeStock($qty);
    }
    public function minusStock($qty){
        return $this->changeStock(-$qty);
    }
    protected function changeStock($qty){
        if($qty===0){
            $this->addError('qty','the qty can not be 0');
            return $this;
        }
        $this->stock+=$qty;
        $this->save();
        return $this;
    }
}
