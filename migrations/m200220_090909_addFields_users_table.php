<?php

use yii\db\Migration;

/**
 * Class m200220_090909_addFields_users_table
 */
class m200220_090909_addFields_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users','teacher', 'boolean');
        $this->addColumn('users','top', 'boolean');
        $this->addColumn('users','fullName', 'string');
        $this->addColumn('users','shortName', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users','teacher');
        $this->dropColumn('users','top');
        $this->dropColumn('users','fullName');
        $this->dropColumn('users','shortName');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200220_090909_addFields_users_table cannot be reverted.\n";

        return false;
    }
    */
}
