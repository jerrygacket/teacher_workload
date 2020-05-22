<?php


namespace app\controllers;


use app\base\BaseController;
use app\models\Departments;
use app\models\FilterForm;
use app\models\Institutes;
use app\models\KafLoad;
use app\models\Load;
use app\models\Users;
use Yii;
use yii\web\Response;

class LoadController extends BaseController
{
    public function actionAllLoad() {
        $this->rbac = $this->getRbac();
        if (!$this->rbac->canViewAllKafLoad()) {
//            if ($this->rbac->canViewKafLoad()) {
//                return $this->redirect('/load/own-kaf-load');
//            }
            return $this->redirect('/auth/login');
        }

        $filterForm = new FilterForm();
        $data = [];
        $totals = [];

        if ($filterForm->load(\Yii::$app->request->post()) && $filterForm->validate()) {
            $model = new Load();
            $data = $model->getCommonLoad($filterForm);
            $totals = [
                '1 семестр' => $model->getTotals($data, 1),
                '2 семестр' => $model->getTotals($data, 2),
                'Год' => $model->getTotals($data),
            ];
        }

        return $this->render('kafLoad', [
            'filterForm' => $filterForm,
            'action' => 'all-load',
            'data' => $data,
            'totals' => $totals,
        ]);
    }

    public function actionKafLoad() {
        $this->rbac = $this->getRbac();
        if (!$this->rbac->canViewAllKafLoad()) {
            return $this->redirect('/auth/login');
        }

        $filterForm = new FilterForm();
        $userModel = new Users();

        if ( \Yii::$app->request->isPost) {
            $filterForm->load(\Yii::$app->request->post());
        }

        $model = new Load();
        $filterForm->department = $userModel::findOne(['id' => \Yii::$app->user->id])->getDepartment()->one()['SHKAF'];
        $data = $model->getCommonLoad($filterForm);
        $totals = [
            '1 семестр' => $model->getTotals($data, 1),
            '2 семестр' => $model->getTotals($data, 2),
            'Год' => $model->getTotals($data),
        ];

        return $this->render('kafLoad', [
            'filterForm' => $filterForm,
            'action' => 'kaf-load',
            'data' => $data,
            'totals' => $totals,
        ]);
    }

    public function actionCalc() {
        $this->rbac = $this->getRbac();
        if (!$this->rbac->canCreateKafLoad()) {
            return $this->redirect('/auth/login');
        }

        $filterForm = new FilterForm();
        $filterForm->currentYear = '2019'; //date('Y');
//        $filterForm->load(\Yii::$app->request->get());
        if ( \Yii::$app->request->isPost) {
            $filterForm->load(\Yii::$app->request->post());
        }

        $model = new Load();
        $filterForm->department = Users::findOne(['id' => \Yii::$app->user->id])->getDepartment()->one()['SHKAF'] ?? 'ИТиС';

//        echo '<pre>';
//        print_r($filterForm);
//        echo '</pre>';
//        \Yii::$app->end(0);

        $data = $model->updateKafLoad($model->getCommonLoad($filterForm));
        $data = $model->getSavedKafLoad($filterForm);
        $users = Users::getTeachers(Users::findOne(['id' => \Yii::$app->user->id])->departmentId);

        $data2 = $model->getCommonLoad($filterForm);
        $totals = [
            '1 семестр' => $model->getTotals($data2, 1),
            '2 семестр' => $model->getTotals($data2, 2),
            'Год' => $model->getTotals($data2),
        ];

//        echo '<pre>';
//        print_r($filterForm);
//        echo '</pre>';
//        \Yii::$app->end(0);

        return $this->render('calc', [
            'filterForm' => $filterForm,
            'action' => 'calc',
            'data' => $data,
            'newData' => $model->newLine,
            'users' => $users,
            'usersHours' => KafLoad::getAllUsersHours(\yii\helpers\ArrayHelper::map($users,'id','id')),
            'totals' => $totals,
        ]);
    }

    public function actionHours() {
        if (Yii::$app->user->isGuest) {
            $result = [
                'error' => true,
                'message' => 'Нужно выполнить вход в систему еще раз.'
            ];
            $this->SendJsonResponse($result);
        }

        if (!isset(Yii::$app->request->queryParams['load_id'])) {
            $result = [
                'error' => true,
                'message' => 'Не указан предмет, заняте и часы.'
            ];
            $this->SendJsonResponse($result);
        }
        if (!isset(Yii::$app->request->queryParams['position_id'])) {
            $result = [
                'error' => true,
                'message' => 'Не указаны часы.'
            ];
            $this->SendJsonResponse($result);
        }
        if (!isset(Yii::$app->request->queryParams['user_id'])) {
            $result = [
                'error' => true,
                'message' => 'Не указан преподаватель.'
            ];
            $this->SendJsonResponse($result);
        }

        $load = KafLoad::findOne(['LOAD_ID' => Yii::$app->request->queryParams['load_id']]);
        if (empty($load)) {
            $result = [
                'error' => true,
                'message' => 'Не найдена нагрузка.'
            ];
            $this->SendJsonResponse($result);
        }
        $load->setUserId(Yii::$app->request->queryParams['user_id']);
        $load->setPositionId(Yii::$app->request->queryParams['position_id']);

        if (!$load->save()) {
            $result = [
                'error' => true,
                'message' => 'Не сохранились часы. '.print_r($load->errors),
            ];
            $this->SendJsonResponse($result);
        }

        //$users = Users::getTeachersIds(Users::findOne(['id' => \Yii::$app->user->id])->departmentId);

        $result = [
            'error' => false,
            'result' => [
                'hours' => KafLoad::getAllUsersHours(),
            ]
        ];


        $this->SendJsonResponse($result);
    }

    public function SendJsonResponse(array $response) {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $object = (object) $response;
        Yii::$app->response->data = $object;
        Yii::$app->response->send();

        Yii::$app->end(0);
    }
}