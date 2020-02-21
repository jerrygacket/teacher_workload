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
}