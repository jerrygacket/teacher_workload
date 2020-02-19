<?php


namespace app\controllers;


use app\base\BaseController;
use app\controllers\actions\IndexAction;
use app\models\Users;
use app\components\UsersComponent;


class UsersController extends BaseController
{
    public function actions()
    {
        return [
//            'create'=>['class'=>ActivityCreateAction::class,'rbac'=>$this->getRbac()],
//            'new'=>['class'=>ActivityCreateAction::class,'rbac'=>$this->getRbac()],
            'index'=>[
                'class'=>IndexAction::class,
                //'rbac'=>$this->getRbac(),
                'component' => UsersComponent::class,
                'model' => Users::class,
            ],
//            'edit'=>['class'=>ActivityCreateAction::class,'rbac'=>$this->getRbac()],
        ];
    }
}