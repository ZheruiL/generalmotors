<?php

use yii\db\Migration;

/**
 * Class m200312_101707_energy
 */
class m200312_101707_energy extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('energy', [
            'id' => $this->primaryKey(),
            'name'=> $this->string()->notNull(),
        ]);

        $this->batchInsert('energy', ['name'], [
            ['Diesel'],
            ['Gasoline'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('energy');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200312_101707_energy cannot be reverted.\n";

        return false;
    }
    */
}
