<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%class}}`.
 */
class m200213_133506_create_class_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%class}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(256),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%class}}');
    }
}
