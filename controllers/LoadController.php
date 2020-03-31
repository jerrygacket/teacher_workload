<?php


namespace app\controllers;


use app\base\BaseController;
use app\models\Departments;
use app\models\FilterForm;
use app\models\Institutes;
use app\models\Load;

class LoadController extends BaseController
{
    public function actionKafLoad() {
        $this->rbac = $this->getRbac();
        if (!$this->rbac->canViewAllKafLoad()) {
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
            'data' => $data,
            'totals' => $totals,
            'institutes' => Institutes::find()->all(),
            'departments' => Departments::find()->all(),
        ]);
    }
}