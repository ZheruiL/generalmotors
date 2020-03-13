<?php

use yii\db\Migration;

/**
 * Class m200312_100132_make
 */
class m200312_100132_make extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('make', [
            'id' => $this->primaryKey(),
            'name'=> $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('make');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200312_100132_make cannot be reverted.\n";

        return false;
    }
    */
}
