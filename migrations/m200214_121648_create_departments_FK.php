<?php

use yii\db\Migration;

/**
 * Class m200214_121648_create_departments_FK
 */
class m200214_121648_create_departments_FK extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('departments_instituteIdFK',
            '{{%departments}}','instituteId','institutes','id',
            'SET NULL','SET NULL');
        $this->addForeignKey('departments_headIdFK',
            '{{%departments}}','headId','users','id',
            'SET NULL','SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('departments_instituteIdFK','{{%departments}}');
        $this->dropForeignKey('departments_headIdFK','{{%departments}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200214_121648_create_departments_FK cannot be reverted.\n";

        return false;
    }
    */
}
