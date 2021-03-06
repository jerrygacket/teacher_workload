<?php

namespace app\controllers;

use Yii;
use yii\db\Connection;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/auth/login']);
        }

        return $this->render('index');
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
//        $model = new ContactForm();
//        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
//            Yii::$app->session->setFlash('contactFormSubmitted');
//
//            return $this->refresh();
//        }
//        return $this->render('contact', [
//            'model' => $model,
//        ]);
    }

    /**
     * Displays about page.
     * @var $db Connection
     * @return string
     */
    public function actionAbout()
    {
//        $db = Yii::createObject(Yii::$app->components['fbDb']);
//        $data = Yii::$app->fbDb->createCommand('select * from FAKUL where CUR_YEAR = 2020')
//        $data = Yii::$app->fbDb->createCommand('select * from KAFEDR where CUR_YEAR = 2020')
        //SHKAF,SEM,SHFAK,KURS,N_GROUP1,POTOK,LEK_FACT,SEM_FACT,LAB_FACT,PRACT_FACT,EKZ_FACT,ZACH_FACT,DIPL_FACT,GOS_EKZ_FACT,NAZV,NAZV1,WSEGO1
//        $data = Yii::$app->fbDb->createCommand('select * from NAGR2016 where CUR_YEAR = 2019')
//            ->queryAll();
//        $data = mb_check_encoding($data, 'UTF-8') ? $data : mb_convert_encoding($data, 'UTF-8', 'CP1251');
//        return $this->render('about', ['data' => $data]);
    }
}
