<?php


namespace app\controllers;


use app\base\BaseController;
use app\components\InstitutesComponent;
use app\controllers\actions\DeleteAction;
use app\controllers\actions\UpdateAction;
use app\models\Institutes;
use app\controllers\actions\IndexAction;
use app\controllers\actions\EditAction;

class InstitutesController extends BaseController
{
    public function actions()
    {
        return [
            'index'=>[
                'class'=>IndexAction::class,
                //'rbac'=>$this->getRbac(),
                'component' => InstitutesComponent::class,
                'model' => Institutes::class,
            ],
            'edit'=>[
                'class'=>EditAction::class,
                //'rbac'=>$this->getRbac(),
                'component' => InstitutesComponent::class,
                'model' => Institutes::class,
            ],
            'update'=>[
                'class'=>UpdateAction::class,
                //'rbac'=>$this->getRbac(),
                'component' => InstitutesComponent::class,
                'model' => Institutes::class,
            ],
            'delete'=>[
                'class'=>DeleteAction::class,
                //'rbac'=>$this->getRbac(),
                'component' => InstitutesComponent::class,
                'model' => Institutes::class,
            ],
        ];
    }
}