<?php


namespace app\controllers;


use app\base\BaseController;
use app\components\AuthComponent;
use app\controllers\actions\IndexAction;
use app\controllers\actions\ViewAction;
use app\models\Users;
use app\components\UsersComponent;
use yii\bootstrap4\ActiveForm;
use yii\web\Response;


class UsersController extends BaseController
{
    public function actions()
    {
        return [
            'index'=>[
                'class'=>IndexAction::class,
                //'rbac'=>$this->getRbac(),
                'component' => UsersComponent::class,
                'model' => Users::class,
            ],
//            'edit'=>[
//                'class'=>IndexAction::class,
//                //'rbac'=>$this->getRbac(),
//                'component' => UsersComponent::class,
//                'model' => Users::class,
//            ],
            'view'=>[
                'class'=>ViewAction::class,
                //'rbac'=>$this->getRbac(),
                'component' => UsersComponent::class,
                'model' => Users::class,
            ],
        ];
    }

    public function actionCreate() {
//        $this->rbac = $this->getRbac();
//        if (!$this->rbac->canCreateUser()) {
//            return $this->redirect('/site/forbidden');
//        }

        $model = new Users();
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if (\Yii::$app->request->isAjax) {
                    \Yii::$app->response->format=Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
                $component = \Yii::createObject(['class' => AuthComponent::class, 'nameClass' => Users::class]);
                if ($component->createUser($model)) {
                    //$authManager = $this->rbac->getAuthManager();
                    //$authManager->assign($authManager->getRole('user'),$model->id);
                    return $this->redirect('index');
                } else {
                    print_r($model->errors);
                    \Yii::$app->end(0);
                }
            }
        }

        return $this->render('create', ['model' => $model]);
    }

}