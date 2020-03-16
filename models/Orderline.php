<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class Orderline extends AbstractOrderline
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['timestamp'] = [
            'class' => TimestampBehavior::class,
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
            ]
        ];
        return $behaviors;
    }

    public function fields()
    {
        return [
            'id',
            'order_id',
            'vehicle_id',
            'description',
            'qty',
            'created_at'=>function(){
                return date('Y-m-d', $this->created_at);
            },
            'updated_at'=>function(){
                return date('Y-m-d', $this->updated_at);
            }
        ];
    }

    public function extraFields()
    {
        return [
            'order',
            'vehicle'
        ];
    }

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['order_id', function(){
            if($this->order->status !== 0){
                // only draft order can be added new record
                $this->addError('order', 'order is not in draft status, can not be modified');
            }
        }];
        return $rules;
    }
}
