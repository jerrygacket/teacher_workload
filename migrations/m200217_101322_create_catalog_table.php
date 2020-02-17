<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%catalog}}`.
 */
class m200217_101322_create_catalog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%catalog}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(256),
            'tableName' => $this->string(256),
            'modelName' => $this->string(256)->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%catalog}}');
    }
}
