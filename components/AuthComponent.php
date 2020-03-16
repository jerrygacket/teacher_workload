<?php


namespace app\components;


use app\models\Users;
use Yii;
use yii\base\Component;

class AuthComponent extends Component
{
    public $nameClass;

    public function getModel() {
        return new $this->nameClass;
    }

    /**
     * @param $model Users
     * @return bool
     */
    public function authUser(&$model):bool{
        $model->setAuthorizationScenario();
        if(!$model->validate(['username','password'])){
            Yii::$app->session->setFlash('userError', 'Неверный пользователь или пароль');
            return false;
        }
        $user = $this->getUserFromLogin($model->username);
        if(empty($user) || !$this->checkPassword($model->password,$user->passwordHash)) {
            Yii::$app->session->setFlash('userError', 'Неверный пользователь или пароль');
            return false;
        }

        return \Yii::$app->user->login($user,$model->rememberMe ? 0 : 3600);
    }

    private function checkPassword($password,$passwordHash){
        return \Yii::$app->security->validatePassword($password,$passwordHash);
    }

    /**
     * @param $username
     * @return Users|array|\yii\db\ActiveRecord|null
     */
    private function getUserFromLogin($username){
        return $this->nameClass::find()->andWhere(['username'=>$username])->one();
    }

    /**
     * @param $model Users
     * @return bool
     */
    public function createUser(&$model):bool{
        $model->setRegistrationScenario();
        $model->passwordHash = $this->hashPassword($model->password);
        $model->auth_key = $this->generateAuthKey();
        //$model->active = 1;
        if($model->save()){
            return true;
        }

        return false;
    }

    /**
     * @param $model Users
     * @return bool
     */
    public function updateUser(&$model):bool{
        if ($model->newPassword != '') {
            $model->password = $model->newPassword;
            if ($model->validate('password')) {
                $model->passwordHash=$this->hashPassword($model->password);
                $model->auth_key=$this->generateAuthKey();
            }
        }
        if($model->save()){
            return true;
        }

        return false;
    }

    private function generateAuthKey(){
        return \Yii::$app->security->generateRandomString();
    }

    private function hashPassword($password){
        return \Yii::$app->security->generatePasswordHash($password);
    }
}