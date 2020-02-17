<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%institutes}}`.
 */
class m200213_132800_create_institutes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%institutes}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(256),
            'fullName' => $this->text(),
            'headId' => $this->integer(5),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%institutes}}');
    }
}
