<?php

use yii\db\Migration;

/**
 * Class m200312_100400_model
 */
class m200312_100400_model extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('model', [
            'id' => $this->primaryKey(),
            'name'=> $this->string()->notNull(),
            'make_id'=>$this->integer()->notNull(),
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            'idx-model-make_id',
            'model',
            'make_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-model-make_id',
            'model',
            'make_id',
            'make',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('model');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200312_100400_model cannot be reverted.\n";

        return false;
    }
    */
}
