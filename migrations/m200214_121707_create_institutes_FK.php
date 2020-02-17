<?php

use yii\db\Migration;

/**
 * Class m200214_121707_create_institutes_FK
 */
class m200214_121707_create_institutes_FK extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('institutes_headIdFK',
            '{{%institutes}}','headId','users','id',
            'SET NULL','SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('institutes_headIdFK','{{%institutes}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200214_121707_create_institutes_FK cannot be reverted.\n";

        return false;
    }
    */
}
