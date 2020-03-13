<?php

use yii\db\Migration;

/**
 * Class m200312_091930_client
 */
class m200312_091930_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('client', [
            'id' => $this->primaryKey(),
            'first_name'=> $this->string()->notNull(),
            'last_name'=> $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'dob' => $this->integer()->notNull(),
            'address' => $this->string(),
            'description' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->batchInsert('client', ['first_name','last_name','email', 'dob', 'address', 'description', 'created_at', 'updated_at'], [
            ['zherui','li','zli@manager.one', 792543600, '8 allee louise bourgois', 'first client', time(), time()],
            ['morgan','adin','madin@manager.one', 732150000, 'unknow', 'nice guy', time(), time()],
            ['andrey','wjizef','azezeji@manager.one', 640562400, 'unknow', 'mystery', time(), time()],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('client');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200312_091930_client cannot be reverted.\n";

        return false;
    }
    */
}
