<?php

namespace app\commands;

use yii\console\Controller;

class DatabaseController extends Controller
{
    //region Controllers Actions
    /**
     * Create a new Admin in the database
     */
    public function actionInit()
    {
        if (!empty(\Yii::$app->components['dbMaster'])) {
            $db = getenv('SQL_DATABASE');
            \Yii::$app->dbMaster->createCommand("if DB_ID('{$db}') is null CREATE DATABASE {{%".$db."}}")->execute();
        }
    }
    //endregion Controllers Actions

    public function actionImportMakeNModel(){
        $path = "web/documents/json/make.json";
        $file = fopen($path, "r") or die("Unable to open file!");
        $array = json_decode(fread($file,filesize($path)),true);
        $makes = array();
        foreach ($array as $value){
            $makes[] = [$value['label']];
        }

        \Yii::$app->db->createCommand()->batchInsert('make',
            ['name'],
            $makes
        )->execute();

        $path = "web/documents/json/model.json";
        $file = fopen($path, "r") or die("Unable to open file!");
        $array = json_decode(fread($file,filesize($path)),true);
        $models = array();
        foreach ($array as $value){
            $models[] = [$value['label'], $value['fk_make']];
        }

        \Yii::$app->db->createCommand()->batchInsert('model',
            ['name','make_id'],
            $models
        )->execute();
    }
}
