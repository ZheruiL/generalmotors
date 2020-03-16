<?php

namespace app\models;

use DateTime;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class Client extends AbstractClient
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

    public function rules(){
        $rules = parent::rules();
        $rules[] = [['first_name', 'last_name', 'email', 'dob'], 'trim'];
        $rules[] = [['email'], 'email'];
        $rules[] = ['dob', function($attribute, $params){
            // YYYY-MM-DD
            $dob = new DateTime($this->$attribute);
            $age = $dob->diff(new DateTime())->y;
            if ($age<18) {
                  $this->addError($attribute, 'The minimum age requirement for a Member is 18 years of age.');
            }
            // todo not sure if it's correct
            $this->dob = $dob->getTimestamp();
          }];
        return $rules;
    }
    public function fields()
    {
        return [
            'id',
            'first_name',
            'last_name',
            'name' => function ($model){
                return $model->last_name." ".$model->first_name;
            },
            'email',
        ];
    }

    public function extraFields()
    {
        return [
            'dob' => function ($model){
                return date('Y-m-d',$model->dob);
            },
            'address',
            'description',
            'orders',
        ];
    }
}
