<?php


namespace app\controllers;


use app\base\BaseController;
use app\components\AuthComponent;
use app\controllers\actions\IndexAction;
use app\controllers\actions\ViewAction;
use app\models\base\UserPositions;
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
                'rbac'=>$this->getRbac(),
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
                'rbac'=>$this->getRbac(),
                'component' => UsersComponent::class,
                'model' => Users::class,
            ],
        ];
    }

    public function actionCreate() {
        $this->rbac = $this->getRbac();
        if (!$this->rbac->canCreateUser()) {
            return $this->redirect('/auth/login');
        }

        $model = new Users();
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if (\Yii::$app->request->isAjax) {
                    \Yii::$app->response->format=Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
                $component = \Yii::createObject(['class' => AuthComponent::class, 'nameClass' => Users::class]);
                if ($component->createUser($model)) {
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

                    return $this->redirect('index');
                } else {
                    print_r($model->errors);
                    \Yii::$app->end(0);
                }
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionAddPosition() {
        $this->rbac = $this->getRbac();
        if (!$this->rbac->canCreateUser()) {
            return $this->redirect('/auth/login');
        }
        $model = new UserPositions();
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post()) && $model->save()) {
                return $this->redirect('view?id='.$model->userId);
            }
        }

        return $this->redirect('/users');
    }

    public function actionDeletePosition() {
        $this->rbac = $this->getRbac();
        if (!$this->rbac->canCreateUser()) {
            return $this->redirect('/auth/login');
        }
        $model = new UserPositions();
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                $userId = $model->userId;
                $model::findOne(['id'=>\Yii::$app->request->post('UserPositions')])->delete();
                //\Yii::$app->db->createCommand()->delete(UserPositions::tableName(), ['id' => $model->id])->execute();
                //print_r();
                //\Yii::$app->end(0);
                return $this->redirect('view?id='.$userId);
            }
        }

        return $this->redirect('/users');
    }
}