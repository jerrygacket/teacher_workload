<?php

namespace app\models;

use app\models\base\UserPositions;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\db\Query;
use yii\web\IdentityInterface;

class Users extends \app\models\base\Users implements IdentityInterface
{
    public $password;
    public $newPassword = '';
    public $rememberMe = false;

    const SCENARIO_REGISTRATION = 'reg_scenario';
    const SCENARIO_AUTHORIZATION = 'auth_scenario';

    public function setRegistrationScenario(){
        $this->setScenario(self::SCENARIO_REGISTRATION);
        return $this;
    }

    public function setAuthorizationScenario(){
        $this->setScenario(self::SCENARIO_AUTHORIZATION);
        return $this;
    }

    public function getUsername(){
        return $this->username;
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['password', 'string','min'=>6, 'message' => 'Короткий пароль'],
            ['username','unique','on' => self::SCENARIO_REGISTRATION, 'message' => 'Такой пользователь уже есть'],
            ['username','exist','on' => self::SCENARIO_AUTHORIZATION],
        ]);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_on', 'updated_on'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_on'],
                ],
                'value' => new Expression('NOW()')
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public static function findIdentity($id)
    {
        return Users::find()->andWhere(['id'=>$id])->one();
    }

    /**
     * @inheritDoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritDoc
     */
    public function setAuthKey($authKey)
    {
        $this->auth_key = $authKey;
    }

    /**
     * @inheritDoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key == $authKey;
    }

    public function getPositions()
    {
        //$positions = new UserPositions();
        return UserPositions::find()->where(['userId' => $this->id])->all();

//        $tableName = 'userPositions';
//        if (\Yii::$app->db->schema->getTableSchema($tableName)) {
//            $rows = new Query;
//            return $rows->select('*')->from($tableName)->where(['userId' => $this->id])->all();
//        }
//
//        return [];
    }

    public function getInstitute()
    {
        $department = $this->getDepartment()->one();
        return Institutes::find()->where(['SHFAK' => $department['SHFAK']])->asArray()->one();
    }
}
