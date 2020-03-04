<?php

use yii\db\Migration;

/**
 * Class m200302_133111_addFields_institutes_table
 */
class m200302_133111_addFields_institutes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('institutes','SHFAK', 'string');
        $this->addColumn('institutes','FAK', 'string');
        $this->addColumn('institutes','NFAK', 'string');
        $this->addColumn('institutes','DEKAN', 'string');
        $this->addColumn('institutes','NFAKR', 'string');
        $this->addColumn('institutes','SEMESTR', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('institutes','SHFAK');
        $this->dropColumn('institutes','FAK');
        $this->dropColumn('institutes','NFAK');
        $this->dropColumn('institutes','DEKAN');
        $this->dropColumn('institutes','NFAKR');
        $this->dropColumn('institutes','SEMESTR');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200302_133111_addFields_institutes_table cannot be reverted.\n";

        return false;
    }
    */
}
