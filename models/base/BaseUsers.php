<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $surname
 * @property string|null $name
 * @property string|null $middleName
 * @property string $username
 * @property string|null $email
 * @property int|null $active
 * @property string|null $passwordHash
 * @property string|null $token
 * @property string|null $auth_key
 * @property int|null $degreeId
 * @property int|null $rankId
 * @property int|null $positionId
 * @property int|null $rateId
 * @property int|null $occupationId
 * @property int|null $departmentId
 * @property string $created_on
 * @property string $updated_on
 *
 * @property Departments[] $departments
 * @property Institutes[] $institutes
 * @property Degree $degree
 * @property Departments $department
 * @property Occupation $occupation
 * @property Position $position
 * @property Rank $rank
 * @property Rate $rate
 */
class BaseUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['active', 'degreeId', 'rankId', 'positionId', 'rateId', 'occupationId', 'departmentId'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['surname', 'name', 'middleName', 'email'], 'string', 'max' => 256],
            [['username'], 'string', 'max' => 128],
            [['passwordHash', 'token', 'auth_key'], 'string', 'max' => 300],
            [['username'], 'unique'],
            [['degreeId'], 'exist', 'skipOnError' => true, 'targetClass' => Degree::className(), 'targetAttribute' => ['degreeId' => 'id']],
            [['departmentId'], 'exist', 'skipOnError' => true, 'targetClass' => Departments::className(), 'targetAttribute' => ['departmentId' => 'id']],
            [['occupationId'], 'exist', 'skipOnError' => true, 'targetClass' => Occupation::className(), 'targetAttribute' => ['occupationId' => 'id']],
            [['positionId'], 'exist', 'skipOnError' => true, 'targetClass' => Position::className(), 'targetAttribute' => ['positionId' => 'id']],
            [['rankId'], 'exist', 'skipOnError' => true, 'targetClass' => Rank::className(), 'targetAttribute' => ['rankId' => 'id']],
            [['rateId'], 'exist', 'skipOnError' => true, 'targetClass' => Rate::className(), 'targetAttribute' => ['rateId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'surname' => Yii::t('app', 'Surname'),
            'name' => Yii::t('app', 'Name'),
            'middleName' => Yii::t('app', 'Middle Name'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'active' => Yii::t('app', 'Active'),
            'passwordHash' => Yii::t('app', 'Password Hash'),
            'token' => Yii::t('app', 'Token'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'degreeId' => Yii::t('app', 'Degree ID'),
            'rankId' => Yii::t('app', 'Rank ID'),
            'positionId' => Yii::t('app', 'Position ID'),
            'rateId' => Yii::t('app', 'Rate ID'),
            'occupationId' => Yii::t('app', 'Occupation ID'),
            'departmentId' => Yii::t('app', 'Department ID'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_on' => Yii::t('app', 'Updated On'),
        ];
    }

    /**
     * Gets query for [[Departments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartments()
    {
        return $this->hasMany(Departments::className(), ['headId' => 'id']);
    }

    /**
     * Gets query for [[Institutes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutes()
    {
        return $this->hasMany(Institutes::className(), ['headId' => 'id']);
    }

    /**
     * Gets query for [[Degree]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDegree()
    {
        return $this->hasOne(Degree::className(), ['id' => 'degreeId']);
    }

    /**
     * Gets query for [[Department]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Departments::className(), ['id' => 'departmentId']);
    }

    /**
     * Gets query for [[Occupation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOccupation()
    {
        return $this->hasOne(Occupation::className(), ['id' => 'occupationId']);
    }

    /**
     * Gets query for [[Position]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(Position::className(), ['id' => 'positionId']);
    }

    /**
     * Gets query for [[Rank]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRank()
    {
        return $this->hasOne(Rank::className(), ['id' => 'rankId']);
    }

    /**
     * Gets query for [[Rate]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRate()
    {
        return $this->hasOne(Rate::className(), ['id' => 'rateId']);
    }
}
