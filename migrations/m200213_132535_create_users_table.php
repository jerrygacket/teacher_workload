<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m200213_132535_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'surname' => $this->string(256),
            'name' => $this->string(256),
            'middleName' => $this->string(256),
            'username'=>$this->string(128)->notNull(),
            'email'=>$this->string(256),
            'active'=>$this->boolean()->null(),
            'passwordHash'=>$this->string(300),
            'token'=>$this->string(300),
            'auth_key'=>$this->string(300),
            'degreeId'=>$this->integer(3)->defaultValue(null),
            'rankId'=>$this->integer(3)->defaultValue(null),
            'positionId'=>$this->integer(3)->defaultValue(null),
            'rateId'=>$this->integer(3)->defaultValue(null),
            'occupationId'=>$this->integer(3)->defaultValue(null),
            'departmentId'=>$this->integer(3)->defaultValue(null),
            'created_on'=>$this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_on'=>$this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->createIndex('users_usernameInd','users','username',true);

        $this->execute('');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
