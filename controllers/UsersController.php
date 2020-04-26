<?php


namespace app\controllers;


use app\base\BaseController;
use app\components\AuthComponent;
use app\controllers\actions\EditAction;
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
//            'index'=>[
//                'class'=>IndexAction::class,
//                'rbac'=>$this->getRbac(),
//                'component' => UsersComponent::class,
//                'model' => Users::class,
//            ],
//            'edit'=>[
//                'class'=>EditAction::class,
//                'rbac'=>$this->getRbac(),
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
//            echo '<pre>';
//            print_r(\Yii::$app->request->post());
//            echo '<pre>';
//            \Yii::$app->end(0);
            if ($model->load(\Yii::$app->request->post())) {
                if (\Yii::$app->request->isAjax) {
                    \Yii::$app->response->format=Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
                $component = \Yii::createObject(['class' => AuthComponent::class, 'nameClass' => Users::class]);
                if ($component->createUser($model)) {
                    $this->setPermissions($model);
                    return $this->redirect('index');
                } else {
                    print_r($model->errors);
                    \Yii::$app->end(0);
                }
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionIndex() {
        $this->rbac = $this->getRbac();
        if (!$this->rbac->canCreateUser()) {
            return $this->redirect('/auth/login');
        }

        $component = \Yii::$app->users;

        $currentUser = $component->getModel(['id' => \Yii::$app->user->id]);
        $roles = \Yii::$app->authManager->getRolesByUser($currentUser->id);
        $isAdmin = array_key_exists('admin', $roles);
        $params = [];
        if (!$isAdmin) {
            $params = ['active' => '1'];
        }

        if ($currentUser->departmentId) {
            $params['departmentId'] = $currentUser->departmentId;
        }
        $provider = $component->getDataProvider($params);

        return $this->render('index', ['provider'=>$provider, 'admin' => $isAdmin]);
    }

    /**
     * @return array|string|Response
     * @throws \yii\base\ExitException
     */
    public function actionEdit() {
        $this->rbac = $this->getRbac();
        if (!$this->rbac->canCreateUser()) {
            return $this->redirect('/auth/login');
        }

        $component = \Yii::$app->users;

        $model = $component->getModel(\Yii::$app->request->queryParams);
        if (\Yii::$app->request->isPost) {
            $model = $component->getModel(['id'=>\Yii::$app->request->post()['Users']['id']]);
            if ($model->load(\Yii::$app->request->post())) {
//                print_r($model);
//                \Yii::$app->end(0);
                if (\Yii::$app->request->isAjax) {
                    \Yii::$app->response->format=Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
                //$component = \Yii::createObject(['class' => AuthComponent::class, 'nameClass' => Users::class]);
                if ($component->updateUser($model)) {
                    $this->setPermissions($model);
                    return $this->redirect('index');
                } else {
                    print_r($model->errors);
                    \Yii::$app->end(0);
                }
            }
        }

        return $this->render('edit', ['model' => $model]);
    }

    public function actionDelete($id) {
        $this->rbac = $this->getRbac();
        if (!$this->rbac->canCreateUser()) {
            return $this->redirect('/auth/login');
        }

        $component = \Yii::$app->users;

        $model = $component->getModel(['id' => $id]);
//        print_r($model);
//        \Yii::$app->end(0);
        if ($model) {
            if (!$component->deleteUser($model)) {
                print_r($model->errors);
                \Yii::$app->end(0);
            }
        }

        return $this->redirect('index');
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

    /**
     * @param $model
     * @throws \Exception
     * @var $authManager \yii\rbac\ManagerInterface
     */
    private function setPermissions($model) {
        $authManager = $this->rbac->getAuthManager();
        $userRoles = $authManager->getRolesByUser($model->id);
        $authManager->revokeAll($model->id);
        if ($model->teacher) {
            $authManager->assign($authManager->getRole('teacher'),$model->id);
        }
        if ($model->top) {
            $authManager->assign($authManager->getRole('top'),$model->id);
        }
        if (!$model->teacher && !$model->top) {
            $authManager->assign($authManager->getRole('user'),$model->id);
        }
    }
}