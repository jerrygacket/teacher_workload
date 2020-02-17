<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%degree}}`.
 */
class m200213_132952_create_degree_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%degree}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(256),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%degree}}');
    }
}
