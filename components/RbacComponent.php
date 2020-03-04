<?php


namespace app\components;


use yii\base\Component;

class RbacComponent extends Component
{
    /**
     * @return \yii\rbac\ManagerInterface
     */
    public function getAuthManager(){
        return \Yii::$app->authManager;
    }

    public function generateRbac(){
        $authManager=$this->getAuthManager();
        /** удаляем все правила */
        $authManager->removeAll();

//        $admin = $authManager->createRole('admin');
//        $user = $authManager->createRole('user');
//        $authManager->add($admin);
//        $authManager->add($user);
//
//        $createChart = $authManager->createPermission('createChart');
//        $createChart->description='Создания графиков';
//        $viewAllChart = $authManager->createPermission('viewAllChart');
//        $viewAllChart->description='Просмотр любых графиков';
//
//        $authManager->add($createChart);
//        $authManager->add($viewAllChart);
//
//        $createUser = $authManager->createPermission('createUser');
//        $createUser->description='Создание пользователей';
//        $viewUsers = $authManager->createPermission('viewUsers');
//        $viewUsers->description='Просмотр пользователей';
//
//        $authManager->add($createUser);
//        $authManager->add($viewUsers);
//
//        $authManager->addChild($user,$viewAllChart);
//        $authManager->addChild($admin,$user);
//        $authManager->addChild($admin,$createChart);
//        $authManager->addChild($admin,$createUser);
//        $authManager->addChild($admin,$viewUsers);
//
//        $authManager->assign($user,2);
//        $authManager->assign($admin,1);
    }

    public function canCreateAll(){
        return \Yii::$app->user->can('createChart');
    }

    public function canViewAll(){
        if(\Yii::$app->user->can('viewAllChart')){
            return true;
        }

        return false;
    }

    public function canCreateUser(){
        if(\Yii::$app->user->can('createUser')){
            return true;
        }

        return false;
    }

    public function canViewUsers(){
        if(\Yii::$app->user->can('viewUsers')){
            return true;
        }

        return false;
    }
}