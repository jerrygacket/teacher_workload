<?php


namespace app\components;


use app\base\BaseComponent;
use app\models\Departments;

class DepartmentsComponent extends BaseComponent
{
    /**
     * @var $model Departments
     * @return mixed
     */
    public function updateFromFB() {
        $newData = $this->getDataFromFB('KAFEDR');

        foreach ($newData as $item) {
            $model = $this->nameClass::findOne(['SHKAF'=>$item['SHKAF']]);
            if (empty($model)) {
                $model = new $this->nameClass;
            }
            $model->attributes = $item;
            $model->name = $item['SHKAF'];
            $model->fullName = $item['NKAF'];

            if (!$model->save()) {
                print_r($model->getErrors());
                \Yii::$app->end();
                return false;
            }
        }

        return true;
    }
}