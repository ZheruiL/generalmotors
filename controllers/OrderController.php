<?php

namespace app\controllers;

use app\models\Order;
use app\models\search\OrderSearch;

/**
 * Class OrderController
 * @method  Order findModel($id)
 */
class OrderController extends AbstractController
{
    public $modelClass = 'app\models\Order';

    public function optional()
    {
        return [];
    }
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex(){
        $request = \Yii::$app->request->queryParams;
        return ((new OrderSearch())->search($request));
    }

    //todo how to avoid repeating these codes
    public function actionAbandon($id){
        $model = $this->findModel($id);
        return $model->abandon();
    }

    public function actionConfirm($id){
        $model = $this->findModel($id);
        return $model->confirm();
    }
    public function actionCancelConfirm($id){
        $model = $this->findModel($id);
        return $model->cancelConfirm();
    }
    public function actionDone($id){
        $model = $this->findModel($id);
        return $model->done();
    }

}