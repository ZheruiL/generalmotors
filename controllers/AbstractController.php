<?php

namespace app\controllers;

use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

abstract class AbstractController extends ActiveController
{
    /**
     * @var ActiveRecord
     */
    public $modelClass;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'optional' => $this->optional(),
        ];

        return $behaviors;
    }

    protected function optional()
    {
        return [];
    }

    public function init()
    {
        if (empty($this->modelClass)) {
            throw new InvalidConfigException('modelClass required');
        }

        parent::init();
    }

    /**
     * @return array
     */
    /*public function actions()
    {
        return [];
    }*/

    protected function findModel($id)
    {
        /** @var ActiveRecord $class */
        $class = $this->modelClass;

        if (($model = $class::findOne($id)) !== null) {
            return $model;
        } else {
            return \Yii::$app->response->setStatusCode(404);
        }
    }
}