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
        $this->batchInsert('{{%users}}',[
            'surname', 'name', 'middleName', 'username', 'email', 'active', 'passwordHash',
        ],[
            ['Иванов','Иван','Иванович','admin','admin@example.com',true,\Yii::$app->security->generatePasswordHash('123456')],
            ['Петрров','Петр','Петрович','ПетровПП','petrov@example.com',true,\Yii::$app->security->generatePasswordHash('123456')],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%users}}');
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
