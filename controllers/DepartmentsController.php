<?php


namespace app\controllers;


use app\base\BaseController;
use app\components\DepartmentsComponent;
use app\controllers\actions\DeleteAction;
use app\controllers\actions\IndexAction;
use app\controllers\actions\EditAction;
use app\controllers\actions\UpdateAction;
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
            'edit'=>[
                'class'=>EditAction::class,
                //'rbac'=>$this->getRbac(),
                'component' => DepartmentsComponent::class,
                'model' => Departments::class,
            ],
            'update'=>[
                'class'=>UpdateAction::class,
                //'rbac'=>$this->getRbac(),
                'component' => DepartmentsComponent::class,
                'model' => Departments::class,
            ],
            'delete'=>[
                'class'=>DeleteAction::class,
                //'rbac'=>$this->getRbac(),
                'component' => DepartmentsComponent::class,
                'model' => Departments::class,
            ],
//            'edit'=>['class'=>ActivityCreateAction::class,'rbac'=>$this->getRbac()],
        ];
    }
}