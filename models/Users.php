<?php

namespace app\models;

use app\models\base\Position;
use app\models\base\Rate;
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

//    public function beforeSave($insert)
//    {
//        if (parent::beforeSave($insert)) {
//            if($this->isNewRecord) {
//                $this->created_on = date('Y-m-d H:i:s');
//                $this->generateAuthKey();
//                $this->setPassword($this->PasswordHash);
//                $this->RulesAccept=1;
//                return true;
//            }
//            else {
//                $this->setPassword($this->PasswordHash);
//                $this->updated_at = date('Y-m-d H:i:s');
//                return true;
//            }
//        }
//    }

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

    public function setPositions($params) {
        UserPositions::deleteAll(['userId' => $this->id]);
        if (isset($params['posId']) && isset($params['occId']) && isset($params['rateId'])) {
            foreach ($params['posId'] as $key => $posId) {
                $userPosition = new UserPositions();
                $userPosition->userId = $this->id;
                $userPosition->occupationId = intval($params['occId'][$key]);
                $userPosition->positionId = intval($posId);
                $userPosition->rateId = intval($params['rateId'][$key]);
                $userPosition->save();
            }
        }
    }

    public function getInstitute()
    {
        $department = $this->getDepartment()->one();

        return Institutes::find()->where(['SHFAK' => $department['SHFAK']])->asArray()->one();
    }

    /**
     * @param $departmentId
     * @var $users Users[]
     * @var $positions Position[]
     */
    public static function getTeachers($departmentId) {
        $result = [];
        $users = self::findAll(['departmentId' => $departmentId, 'active' => 1, 'teacher' => 1]);
        foreach ($users as $user) {
            $positions = $user->getPositions();
            foreach ($positions as $position) {
                $result[] = [
                    'id' => $user->id,
                    'fio' => implode(' ', [$user->surname, $user->name,$user->middleName]),
                    'position' => Position::find()->where(['id'=>$position->positionId])->one()['name'],
                    'positionId' => $position->positionId,
                    'rate' => Rate::find()->where(['id'=>$position->rateId])->one()['name'],
                    'rateId' => $position->rateId
                ];
            }
        }

        return $result;
    }

    public static function getTeachersIds($departmentId) {
        $users = self::findAll(['departmentId' => $departmentId, 'active' => 1, 'teacher' => 1]);
        return \yii\helpers\ArrayHelper::map($users,'id','id');
    }
}
