<?php


namespace app\controllers;


use app\base\BaseController;
use app\components\InstitutesComponent;
use app\models\Institutes;
use app\controllers\actions\IndexAction;

class InstitutesController extends BaseController
{
    public function actions()
    {
        return [
//            'create'=>['class'=>ActivityCreateAction::class,'rbac'=>$this->getRbac()],
//            'new'=>['class'=>ActivityCreateAction::class,'rbac'=>$this->getRbac()],
            'index'=>[
                'class'=>IndexAction::class,
                //'rbac'=>$this->getRbac(),
                'component' => InstitutesComponent::class,
                'model' => Institutes::class,
            ],
//            'edit'=>['class'=>ActivityCreateAction::class,'rbac'=>$this->getRbac()],
        ];
    }
}