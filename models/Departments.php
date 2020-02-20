<?php

namespace app\models;

use app\models\base\BaseDepartments;

class Departments extends BaseDepartments
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
