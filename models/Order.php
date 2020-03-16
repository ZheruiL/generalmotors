<?php

namespace app\models;

use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Order extends AbstractOrder
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
            'ref',
            'description',
            'status',
            'status_label'=>function(){
                return $this->getStatusLabel();
            },
            'created_at'=>function(Order $model){
                return date('Y-m-d',$model->created_at);
            },
            'updated_at'=>function(Order $model){
                return date('Y-m-d',$model->updated_at);
            },
        ];
    }

    public function extraFields()
    {
        return [
            'clients',
            'orderlines'
        ];
    }

    public function getStatusLabel(){
        switch ($this->status) {
            case 0:
                return 'draft';
            case 1:
                return 'confirm';
            case 2:
                return 'done';
            case 5:
                return 'abandoned';
            default:
                return 'unknown';
        }
    }

    public function abandon(){
        return $this->changeStatus(false, 5);
    }
    public function confirm(){
        return $this->changeStatus(0,1, 'this order is not under draft status');
    }

    public function done(){
        $model = $this;
        // $this->changeStatus(1,2, 'this order is not under confirmed status');
        //todo minus stock if it's done
        try {
            $model = \Yii::$app->db->transaction(function () use (&$model) {
                $model->changeStatus(1,2, 'this order is not under confirmed status');
                if($model->hasErrors()){
                    throw new \Exception('status can not be updated');
                }
                $orderLines = $model->orderlines;
                foreach ($orderLines as $orderLine){
                    if($orderLine->vehicle_id !== null){
                        //minus stock
                        $qty = $orderLine->qty;
                        $minusStock = $orderLine->vehicle->minusStock($qty);
                        if($minusStock->hasErrors()){
                            $model = $minusStock;
                            throw new \Exception('Stock can not be updated');
                        }
                    }
                }
                return $model;
            });
        } catch (\Exception $e) {
            if (!$model->hasErrors()) {
                throw new \Exception('An error occurred.');
            }
        }
        return $model;
    }

    public function cancelConfirm(){
        return $this->changeStatus(1,0,'this order is not under confirmed status');
    }

    private function changeStatus($oldStatus, $newStatus, $errorMessage=null){
        if($oldStatus===false || $this->status === $oldStatus){
            $this->status=$newStatus;
            $this->save();
        }
        else{
            $this->addError('status',$errorMessage);
        }
        return $this;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->getIsNewRecord()) {
            // rename ref
            // todo get the next insert id before save
            $this->ref = date("Ym-his");
            return $this->insert($runValidation, $attributeNames);
        }

        return $this->update($runValidation, $attributeNames) !== false;
    }
}
