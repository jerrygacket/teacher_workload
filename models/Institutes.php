<?php

namespace app\models;

use Yii;

class Institutes extends \app\models\base\Institutes
{

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['name', 'required'],
            ['name', 'trim'],
            ['fullName', 'required'],
            ['fullName', 'trim'],
            [['SHFAK', 'FAK', 'NFAK', 'DEKAN', 'NFAKR', 'SEMESTR'], 'safe'],
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
