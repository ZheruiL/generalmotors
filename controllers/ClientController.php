<?php

namespace app\controllers;

use app\models\Client;
// use app\models\TaskGroup;
// use app\models\TaskUser;
use app\models\search\ClientSearch;
use yii\helpers\ArrayHelper;

class ClientController extends AbstractController
{
    public $modelClass = 'app\models\Client';

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
        return (new ClientSearch())->search($request);
    }
}