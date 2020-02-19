<?php

namespace app\models;

use app\models\base\BaseInstitutes;
use Yii;

/**
 * This is the model class for table "institutes".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $fullName
 * @property int|null $headId
 *
 * @property Departments[] $departments
 * @property Users $head
 */
class Institutes extends BaseInstitutes
{
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
            'head' => Yii::t('app', 'Head'),
        ];
    }

    /**
     * Gets query for [[Departments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartments()
    {
        return $this->hasMany(Departments::className(), ['instituteId' => 'id']);
    }

    /**
     * @return string|\yii\db\ActiveQuery
     */
    public function getHead()
    {
        $user = $this->headId ? $this->hasOne(Users::className(), ['id' => 'headId'])->asArray() : null;
        return $user ? $user['surname'].' '.$user['name'].' '.$user['middleName'] : '';
    }
}
