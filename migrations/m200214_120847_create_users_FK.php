<?php

use yii\db\Migration;

/**
 * Class m200214_120847_create_users_FK
 */
class m200214_120847_create_users_FK extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('users_degreeIdFK',
            '{{%users}}','degreeId','degree','id',
            'SET NULL','SET NULL');
        $this->addForeignKey('users_rankIdFK',
            '{{%users}}','rankId','rank','id',
            'SET NULL','SET NULL');
        $this->addForeignKey('users_positionIdFK',
            '{{%users}}','positionId','position','id',
            'SET NULL','SET NULL');
        $this->addForeignKey('users_rateIdFK',
            '{{%users}}','rateId','rate','id',
            'SET NULL','SET NULL');
        $this->addForeignKey('users_occupationIdFK',
            '{{%users}}','occupationId','occupation','id',
            'SET NULL','SET NULL');
        $this->addForeignKey('users_departmentIdFK',
            '{{%users}}','departmentId','departments','id',
            'SET NULL','SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('users_degreeIdFK','{{%users}}');
        $this->dropForeignKey('users_rankIdFK','{{%users}}');
        $this->dropForeignKey('users_positionIdFK','{{%users}}');
        $this->dropForeignKey('users_rateIdFK','{{%users}}');
        $this->dropForeignKey('users_occupationIdFK','{{%users}}');
        $this->dropForeignKey('users_departmentIdFK','{{%users}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200214_120847_create_users_FK cannot be reverted.\n";

        return false;
    }
    */
}
