<?php


namespace app\components;


use app\base\BaseComponent;
use app\models\Users;

class UsersComponent extends BaseComponent
{
    private function generateAuthKey(){
        return \Yii::$app->security->generateRandomString();
    }

    private function hashPassword($password){
        return \Yii::$app->security->generatePasswordHash($password);
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
}