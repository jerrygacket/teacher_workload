<?php


namespace app\components;


use app\base\BaseComponent;
use app\models\base\UserPositions;
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
        if (!$model->validate('password')) {
            $model->password = $this->generateAuthKey();
        }
        $model->passwordHash = $this->hashPassword($model->password);
        $model->auth_key = $this->generateAuthKey();

        //$model->active = 1;
        if($model->save()){
            $this->setPermissions($model);
            $postVars = \Yii::$app->request->post();
            if (isset($postVars['posId']) && isset($postVars['occId']) && isset($postVars['rateId'])) {
                foreach ($postVars['posId'] as $key => $posId) {
                    $userPosition = new UserPositions();
                    $userPosition->userId = $model->id;
                    $userPosition->occupationId = intval($postVars['occId'][$key]);
                    $userPosition->positionId = intval($posId);
                    $userPosition->rateId = intval($postVars['rateId'][$key]);
                    $userPosition->save();
                }
            }
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
            $this->setPermissions($model);
            return true;
        }

        return false;
    }

    /**
     * @param $model Users
     * @return bool
     */
    public function deleteUser(&$model):bool{
        $model->active = 0;

        return $model->save();
    }

    private function setPermissions($model) {
        $authManager = $this->rbac->getAuthManager();
        if ($model->teacher) {
            $authManager->assign($authManager->getRole('teacher'),$model->id);
        }
        if ($model->top) {
            $authManager->assign($authManager->getRole('top'),$model->id);
        }
        if (!$model->teacher && !$model->top) {
            $authManager->assign($authManager->getRole('teacher'),$model->id);
        }
    }
}