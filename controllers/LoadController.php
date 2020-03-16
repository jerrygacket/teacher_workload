<?php


namespace app\controllers;


use app\base\BaseController;
use app\models\Departments;
use app\models\FilterForm;
use app\models\Institutes;

class LoadController extends BaseController
{
    public function actionKafLoad() {
        //$tableName = Yii::$app->request->getBodyParam('table', null);
        $filterForm = new FilterForm();

        if ($filterForm->load(\Yii::$app->request->post()) && $filterForm->validate()) {
            $sql = 'select * from NAGR2016 where CUR_YEAR='.($filterForm->currentYear == '' ? date('Y') : $filterForm->currentYear);
            if (!empty($filterForm->institute)) {
//                $sql .= ' and SHFAK=:shfak';
                $sql .= ' and SHFAK=\''.$filterForm->institute.'\'';
            }
            if (!empty($filterForm->department)) {
//                $sql .= ' and SHKAF=:shkaf';
                $sql .= ' and SHKAF=\''.$filterForm->department.'\'';
            }
//            echo $sql;
//            \Yii::$app->end(0);
//            $params = [
//                ':currentYear' => $filterForm->currentYear,
//                ':shfak' => $filterForm->institute,
//                ':shkaf' => $filterForm->department,
//            ];
            $data = \Yii::$app->fbDb->createCommand(mb_convert_encoding($sql, 'CP1251', 'UTF-8'))
                //->andwhere('CUR_YEAR=:CUR_YEAR', array(':CUR_YEAR'=>'2020'))
                //->queryRow();
                ->queryAll();
        } else {
            $data = \Yii::$app->fbDb->createCommand('select * from NAGR2016 where CUR_YEAR = 2020')
                ->queryAll();
        }

        $data = mb_check_encoding($data, 'UTF-8') ? $data : mb_convert_encoding($data, 'UTF-8', 'CP1251');

        return $this->render('kafLoad', [
            'filterForm' => $filterForm,
            'data' => $data,
            'institutes' => Institutes::find()->all(),
            'departments' => Departments::find()->all(),
        ]);
    }
}