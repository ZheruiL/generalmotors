<?php

namespace app\commands;

use yii\console\Controller;

class ExampleController extends Controller
{
    /**
     * @param null $message
     * @return string|null
     */
    public function actionHelloWorld($message = null)
    {
        if (empty($message)) {
            $message = 'Hello World!';
        }

        echo $message;
    }
}
