<?php

use yii\db\Migration;

/**
 * Class m200312_103439_order
 */
class m200312_103439_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'ref' => $this->string(),
            'status' => $this->integer()->defaultValue(0),
            'description' => $this->text(),
            'client_id'=>$this->integer(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer()
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            'idx-order-client_id',
            'order',
            'client_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-order-client_id',
            'order',
            'client_id',
            'client',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200312_103439_order cannot be reverted.\n";

        return false;
    }
    */
}
