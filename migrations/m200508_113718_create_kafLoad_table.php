<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%kafLoad}}`.
 */
class m200508_113718_create_kafLoad_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%kafLoad}}', [
                'ID' => $this->primaryKey(),
                'LOAD_ID' => $this->string(1024),
                'USER_ID' => $this->integer(5)->null(),
                'POSITION_ID' => $this->integer(5)->null(),
                'SEM' => $this->integer(3),
                'INDEX_D' => $this->string(256),
                'NAZV1' => $this->string(256),
                'SHFAK'=>$this->string(128),
                'SHKAF'=>$this->string(256),
                'KURS'=>$this->integer(3),
                'STUD'=>$this->integer(3),
                'NPOT'=>$this->integer(3),
                'K_GR'=>$this->integer(3),
                'P_GR'=>$this->integer(3),
                'N_GROUP1'=>$this->string(128),
                'POTOK'=>$this->string(128),
                'WSEGO1'=>$this->float(5),
                'PRIM'=>$this->string(128),
                'HOURS'=>$this->float(5),
                'TYPE'=>$this->string(128),
                'created_on'=>$this->timestamp()->notNull()
                    ->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_on'=>$this->timestamp()->notNull()
                    ->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%kafLoad}}');
    }
}
