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
        return $this->headId ? $this->hasOne(Users::className(), ['id' => 'headId']) : null;
    }
}
