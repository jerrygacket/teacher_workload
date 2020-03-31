<?php


namespace app\controllers;


use app\components\RbacComponent;
use yii\base\Controller;

class RbacController extends Controller
{
    public function actionGen(){
        /** @var RbacComponent $rbac */
        $rbac = \Yii::$app->rbac;
        $rbac->generateRbac();
        return 'no actions';
    }
}