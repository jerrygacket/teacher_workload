<?php

use yii\db\Migration;

/**
 * Class m200216_111553_addData_users_table
 */
class m200216_111553_addData_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200216_111553_addData_users_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200216_111553_addData_users_table cannot be reverted.\n";

        return false;
    }
    */
}
