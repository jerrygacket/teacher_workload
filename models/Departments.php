<?php

namespace app\models;

class Departments extends \app\models\base\Departments
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['name', 'required'],
            ['name', 'trim'],
            ['fullName', 'required'],
            ['fullName', 'trim'],
        ]);
    }

    /**
     * @return string|\yii\db\ActiveQuery
     */
    public function getHead()
    {
        $user = $this->headId ? $this->hasOne(Users::className(), ['id' => 'headId'])->asArray() : null;
        return $user ? $user['fullName'] : '';
    }
}
