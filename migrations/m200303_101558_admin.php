<?php

use yii\db\Migration;

class m200303_101558_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
            'login' => $this->string()->notNull(),
            'password' => $this->string(),
            'roles' => $this->text(),
        ]);

        $this->insert('admin', [
            'login' => 'zli',
            'password' => '$2y$13$V92/9G0iKy/66mZmZjYwEuKj2KOhIvRJaviw.O7qpIq9JFwMZyW5G',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('admin');
    }
}
