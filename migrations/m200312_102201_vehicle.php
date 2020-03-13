<?php

use yii\db\Migration;

/**
 * Class m200312_102201_vehicle
 */
class m200312_102201_vehicle extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vehicle', [
            'id' => $this->primaryKey(),
            'model_id'=>$this->integer()->notNull(),
            'energy_id'=>$this->integer()->notNull(),
            'year'=>$this->integer(),
            'description'=>$this->text(),
            'stock'=>$this->integer()->defaultValue(0),
        ]);

        // creates index for column `model_id`
        $this->createIndex(
            'idx-vehicle-model_id',
            'vehicle',
            'model_id'
        );

        // add foreign key for table `model`
        $this->addForeignKey(
            'fk-vehicle-model_id',
            'vehicle',
            'model_id',
            'model',
            'id',
            'CASCADE'
        );

        // creates index for column `energy`
        $this->createIndex(
            'idx-vehicle-energy_id',
            'vehicle',
            'energy_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-vehicle-energy_id',
            'vehicle',
            'energy_id',
            'energy',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vehicle');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200312_102201_vehicle cannot be reverted.\n";

        return false;
    }
    */
}
