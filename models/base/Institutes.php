<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "institutes".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $fullName
 * @property int|null $headId
 * @property string|null $SHFAK
 * @property string|null $FAK
 * @property string|null $NFAK
 * @property string|null $DEKAN
 * @property string|null $NFAKR
 * @property string|null $SEMESTR
 *
 * @property Departments[] $departments
 * @property Users $head
 */
class Institutes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'institutes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fullName'], 'string'],
            [['headId'], 'integer'],
            [['name'], 'string', 'max' => 256],
            [['SHFAK', 'FAK', 'NFAK', 'DEKAN', 'NFAKR', 'SEMESTR'], 'string', 'max' => 255],
            [['headId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['headId' => 'id']],
        ];
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
            'SHFAK' => Yii::t('app', 'Shfak'),
            'FAK' => Yii::t('app', 'Fak'),
            'NFAK' => Yii::t('app', 'Nfak'),
            'DEKAN' => Yii::t('app', 'Dekan'),
            'NFAKR' => Yii::t('app', 'Nfakr'),
            'SEMESTR' => Yii::t('app', 'Semestr'),
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
     * Gets query for [[Head]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHead()
    {
        return $this->hasOne(Users::className(), ['id' => 'headId']);
    }
}
