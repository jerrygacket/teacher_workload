<?php


namespace app\controllers;


use app\base\BaseController;
use app\models\Departments;
use app\models\FilterForm;
use app\models\Institutes;
use app\models\Load;
use app\models\Users;

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
        if ( \Yii::$app->request->isPost) {
            $filterForm->load(\Yii::$app->request->post());
        }

        $model = new Load();
        $filterForm->department = Users::findOne(['id' => \Yii::$app->user->id])->getDepartment()->one()['SHKAF'];

        $data = $model->getKafLoad($model->getCommonLoad($filterForm));
//        $totals = [
//            '1 семестр' => $model->getTotals($data, 1),
//            '2 семестр' => $model->getTotals($data, 2),
//            'Год' => $model->getTotals($data),
//        ];

        return $this->render('calc', [
            'filterForm' => $filterForm,
            'action' => 'calc',
            'data' => $data,
//            'totals' => $totals,
        ]);
    }
}