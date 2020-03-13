<?php

namespace app\controllers;

use app\models\Admin;
use app\models\LoginForm;
use yii\filters\auth\HttpBasicAuth;

class AdminController extends AbstractController
{
    public function init()
    {
        $this->modelClass = Admin::class;

        parent::init();
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function ($login, $password) {
                $model = new LoginForm();
                $load = $model->load(['login'=>$login, 'password'=>$password], '');

                if ($load && ($token = $model->login())) {
                    $user = $model->getUser();
                    $user->token = $token;
                    return $user;
                }

                return null;
            },
        ];
        return $behaviors;
    }

    public function optional()
    {
        return ['login'];
    }

    public function actionLogin()
    {
        return ['token'=>\Yii::$app->user->identity->token];
    }
}