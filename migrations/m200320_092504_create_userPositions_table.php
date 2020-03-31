<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%userPositions}}`.
 */
class m200320_092504_create_userPositions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%userPositions}}', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer(5),
            'positionId' => $this->integer(5),
            'rateId' => $this->integer(5),
            'occupationId' => $this->integer(5),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%userPositions}}');
    }
}
