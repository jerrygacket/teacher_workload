<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "departments".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $fullName
 * @property int|null $headId
 * @property int|null $instituteId
 * @property string|null $SHKAF
 * @property string|null $ZAV
 * @property string|null $VIP
 * @property string|null $FKAF
 * @property string|null $SHFAK
 * @property string|null $KAF
 * @property string|null $NKAF
 * @property string|null $KAF1
 * @property string|null $KAF2
 * @property string|null $KAF3
 * @property string|null $KAFEDRA
 * @property string|null $SEMESTR
 *
 * @property Users $head
 * @property Institutes $institute
 * @property Users[] $users
 */
class Departments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'departments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fullName'], 'string'],
            [['headId', 'instituteId'], 'integer'],
            [['name'], 'string', 'max' => 256],
            [['SHKAF', 'ZAV', 'VIP', 'FKAF', 'SHFAK', 'KAF', 'NKAF', 'KAF1', 'KAF2', 'KAF3', 'KAFEDRA', 'SEMESTR'], 'string', 'max' => 255],
            [['headId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['headId' => 'id']],
            [['instituteId'], 'exist', 'skipOnError' => true, 'targetClass' => Institutes::className(), 'targetAttribute' => ['instituteId' => 'id']],
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
            'instituteId' => Yii::t('app', 'Institute ID'),
            'SHKAF' => Yii::t('app', 'Shkaf'),
            'ZAV' => Yii::t('app', 'Zav'),
            'VIP' => Yii::t('app', 'Vip'),
            'FKAF' => Yii::t('app', 'Fkaf'),
            'SHFAK' => Yii::t('app', 'Shfak'),
            'KAF' => Yii::t('app', 'Kaf'),
            'NKAF' => Yii::t('app', 'Nkaf'),
            'KAF1' => Yii::t('app', 'Kaf1'),
            'KAF2' => Yii::t('app', 'Kaf2'),
            'KAF3' => Yii::t('app', 'Kaf3'),
            'KAFEDRA' => Yii::t('app', 'Kafedra'),
            'SEMESTR' => Yii::t('app', 'Semestr'),
        ];
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

    /**
     * Gets query for [[Institute]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInstitute()
    {
        return $this->hasOne(Institutes::className(), ['id' => 'instituteId']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['departmentId' => 'id']);
    }
}
