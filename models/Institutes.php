<?php

namespace app\models;

use app\models\base\BaseInstitutes;
use Yii;

class Institutes extends BaseInstitutes
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'fullName' => Yii::t('app', 'Full Name'),
            'headId' => Yii::t('app', 'Head ID'),
        ];
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
