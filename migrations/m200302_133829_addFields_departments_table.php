<?php

use yii\db\Migration;

/**
 * Class m200302_133829_addFields_departments_table
 */
class m200302_133829_addFields_departments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('departments','SHKAF', 'string');
        $this->addColumn('departments','ZAV', 'string');
        $this->addColumn('departments','VIP', 'string');
        $this->addColumn('departments','FKAF', 'string');
        $this->addColumn('departments','SHFAK', 'string');
        $this->addColumn('departments','KAF', 'string');
        $this->addColumn('departments','NKAF', 'string');
        $this->addColumn('departments','KAF1', 'string');
        $this->addColumn('departments','KAF2', 'string');
        $this->addColumn('departments','KAF3', 'string');
        $this->addColumn('departments','KAFEDRA', 'string');
        $this->addColumn('departments','SEMESTR', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('departments','SHKAF');
        $this->dropColumn('departments','ZAV');
        $this->dropColumn('departments','VIP');
        $this->dropColumn('departments','FKAF');
        $this->dropColumn('departments','SHFAK');
        $this->dropColumn('departments','KAF');
        $this->dropColumn('departments','KAF1');
        $this->dropColumn('departments','KAF2');
        $this->dropColumn('departments','KAF3');
        $this->dropColumn('departments','KAFEDRA');
        $this->dropColumn('departments','SEMESTR');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200302_133829_addFields_departments_table cannot be reverted.\n";

        return false;
    }
    */
}
