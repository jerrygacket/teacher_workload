<?php


namespace app\controllers;


use app\components\AuthComponent;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    /**
     * @var AuthComponent
     */
    public $component;

    public function init()
    {
        parent::init();

        $this->component = Yii::createObject([
            'class' => AuthComponent::class,
            'nameClass' => '\app\models\Users'
        ]);
    }

    public function actionLogin() {
        $model = $this->component->getModel();
        if (Yii::$app->request->isPost) {
            if(!$model->load(\Yii::$app->request->post())) {
                Yii::$app->session->setFlash('userError', 'Неверный пользователь или пароль');
                return $this->render('login', ['model' => $model]);
            }
            if($this->component->authUser($model)){
                return $this->redirect(['/site/index']);
            }
        }

        return $this->render('login', ['model' => $model]);
    }

    public function actionLogout() {
        if (!Yii::$app->user->isGuest)
        Yii::$app->user->logout();

        return $this->goHome();
    }

}