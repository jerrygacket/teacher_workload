<?php

namespace app\models\base;

use app\models\Institutes;
use app\models\Users;
use Yii;

/**
 * This is the model class for table "departments".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $fullName
 * @property int|null $headId
 * @property int|null $instituteId
 *
 * @property Users $head
 * @property Institutes $institute
 * @property Users[] $users
 */
class BaseDepartments extends \yii\db\ActiveRecord
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
