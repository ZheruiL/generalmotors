<?php

namespace app\controllers;

use app\models\search\VehicleSearch;
use app\models\Vehicle;
use yii\helpers\ArrayHelper;

/**
 * Class VehicleController
 * @method Vehicle findModel($id)
 */
class VehicleController extends AbstractController
{
    public $modelClass = 'app\models\Vehicle';

    public function optional()
    {
        return [];
    }
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        // unset($actions['create']);
        // unset($actions['update']);
        return $actions;
    }

    public function actionIndex(){
        $request = \Yii::$app->request->queryParams;
        return ((new VehicleSearch())->search($request));
    }

    public function actionIncreaseStock($id){
        return $this->changeStock($id, 'increaseStock');
    }

    public function actionMinusStock($id){
        return $this->changeStock($id, 'minusStock');
    }

    public function changeStock($id, $method){
        $model = $this->findModel($id);
        $request = \Yii::$app->request->bodyParams;
        $qty = ArrayHelper::getValue($request, 'qty', 0);
        return call_user_func_array(array($model,$method), array($qty));
    }

}