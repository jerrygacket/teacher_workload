<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rank}}`.
 */
class m200213_132929_create_rank_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rank}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(256),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rank}}');
    }
}
