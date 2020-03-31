<?php


namespace app\components;


use app\models\Users;
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

        $admin = $authManager->createRole('admin');
        $user = $authManager->createRole('user');
        $top = $authManager->createRole('top');
        $teacher = $authManager->createRole('teacher');
        $authManager->add($admin);
        $authManager->add($user);
        $authManager->add($top);
        $authManager->add($teacher);

        // ***************************************
        $createKafLoad = $authManager->createPermission('createKafLoad');
        $createKafLoad->description = 'Создание кафедральной нагрузки';
        $viewAllKafLoad = $authManager->createPermission('viewAllKafLoad');
        $viewAllKafLoad->description='Просмотр любых нагрузок';
        $viewOwnerKafLoad = $authManager->createPermission('viewOwnerKafLoad');
        $viewOwnerKafLoad->description='Просмотр нагрузок своей кафедры';
        $viewOwnerLoad = $authManager->createPermission('viewOwnerLoad');
        $viewOwnerLoad->description='Просмотр своих нагрузок';

        $createCatalog = $authManager->createPermission('createCatalog');
        $createCatalog->description='Создание и обновление справочников';

        $createUser = $authManager->createPermission('createUser');
        $createUser->description='Создание пользователей';
//        $createTeacher = $authManager->createPermission('createTeacher');
//        $createTeacher->description='Создание учителей';
        $viewUsers = $authManager->createPermission('viewUsers');
        $viewUsers->description='Просмотр пользователей';
        // ***************************************
        $authManager->add($createKafLoad);
        $authManager->add($viewAllKafLoad);
        $authManager->add($viewOwnerKafLoad);
        $authManager->add($viewOwnerLoad);
        $authManager->add($createCatalog);

        $authManager->add($createUser);
        $authManager->add($viewUsers);
        // ***************************************

        $authManager->addChild($teacher,$viewOwnerLoad);
        $authManager->addChild($top,$viewAllKafLoad);

        $authManager->addChild($user,$viewOwnerKafLoad);
        $authManager->addChild($user,$createKafLoad);
        $authManager->addChild($user,$createUser);

        $authManager->addChild($admin,$user);
        $authManager->addChild($admin,$createCatalog);
        $authManager->addChild($admin,$viewAllKafLoad);
        $authManager->addChild($admin,$viewUsers);
        // ***************************************

        /**
         * @var $users Users[]
         */
        $users = Users::find()->all();
        foreach ($users as $item) {
            if ($item->teacher) {
                $authManager->assign($teacher,$item->id);
            }
            if ($item->top) {
                $authManager->assign($top,$item->id);
            }
            if (!$item->teacher && !$item->top) {
                $authManager->assign($user,$item->id);
            }
            if ($item->username == 'admin') {
                $authManager->assign($admin,$item->id);
            }
        }
    }

    public function canCreateKafLoad(){
        return \Yii::$app->user->can('createKafLoad');
    }

    public function canCreateCatalog(){
        return \Yii::$app->user->can('createCatalog');
    }

    public function canViewKafLoad(){
        return \Yii::$app->user->can('viewOwnerKafLoad');
    }

    public function canViewAllKafLoad(){
        if(\Yii::$app->user->can('viewAllKafLoad')){
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