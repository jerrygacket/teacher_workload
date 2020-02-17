<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%occupation}}`.
 */
class m200213_133209_create_occupation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%occupation}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(256),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%occupation}}');
    }
}
