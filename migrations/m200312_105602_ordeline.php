<?php

use yii\db\Migration;

/**
 * Class m200312_105602_ordeline
 */
class m200312_105602_ordeline extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('orderline', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'vehicle_id' => $this->integer(),
            'description' => $this->text(),
            'qty'=>$this->integer()->notNull(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer()
        ]);

        // creates index for column `order_id`
        $this->createIndex(
            'idx-orderline-order_id',
            'orderline',
            'order_id'
        );

        // add foreign key for table `order`
        $this->addForeignKey(
            'fk-orderline-order_id',
            'orderline',
            'order_id',
            'order',
            'id',
            'CASCADE'
        );


        // creates index for column `vehicle_id`
        $this->createIndex(
            'idx-orderline-vehicle_id',
            'orderline',
            'vehicle_id'
        );

        // add foreign key for table `vehicle`
        $this->addForeignKey(
            'fk-orderline-vehicle_id',
            'orderline',
            'vehicle_id',
            'vehicle',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('orderline');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200312_105602_ordeline cannot be reverted.\n";

        return false;
    }
    */
}
