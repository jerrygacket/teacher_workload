<?php

use yii\db\Migration;

/**
 * Class m200217_101341_addData_catalog_table
 */
class m200217_101341_addData_catalog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%catalog}}',[
            'name', 'tableName', 'modelName'
        ],[
            ['Пользователи','users','Users'],
            ['Институты','institutes','Institutes'],
            ['Кафедры','departments','Departments'],
            ['Должности','position',null],
            ['Степени','degree',null],
            ['Звания','rank',null],
            ['Ставки','rate',null],
            ['Типы занятости','occupation',null],
            ['Типы занятий','class',null],
            ['Предметы','subject',null],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%catalog}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200217_101341_addData_catalog_table cannot be reverted.\n";

        return false;
    }
    */
}
