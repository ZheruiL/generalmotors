<?php

namespace app\controllers;

use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

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
     * @param $id
     * @return ActiveRecord|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        /** @var ActiveRecord $class */
        $class = $this->modelClass;

        if (($model = $class::findOne($id)) !== null) {
            return $model;
        }
        // return \Yii::$app->response->setStatusCode(404);
        throw New NotFoundHttpException();
    }
}