<?php

namespace app\controllers;

use app\models\Orderline;

class OrderlineController extends AbstractController
{
    public $modelClass = 'app\models\Orderline';

    public function optional()
    {
        return [];
    }
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        return $actions;
    }

    // check if order status permit insert
    public function actionCreate(){
        $request = \Yii::$app->request->bodyParams;
        return (new Orderline())->saveOrderline($request);
    }
    public function actionUpdate(){
        $request = \Yii::$app->request->bodyParams;
        return (new Orderline())->saveOrderline($request);
    }
}