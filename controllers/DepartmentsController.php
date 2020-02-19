<?php


namespace app\controllers;


use app\base\BaseController;
use app\components\DepartmentsComponent;
use app\controllers\actions\IndexAction;
use app\models\Departments;

class DepartmentsController extends BaseController
{
    public function actions()
    {
        return [
//            'create'=>['class'=>ActivityCreateAction::class,'rbac'=>$this->getRbac()],
//            'new'=>['class'=>ActivityCreateAction::class,'rbac'=>$this->getRbac()],
            'index'=>[
                'class'=>IndexAction::class,
                //'rbac'=>$this->getRbac(),
                'component' => DepartmentsComponent::class,
                'model' => Departments::class,
            ],
//            'edit'=>['class'=>ActivityCreateAction::class,'rbac'=>$this->getRbac()],
        ];
    }
}