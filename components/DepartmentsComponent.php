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
            $model->load($item);

            if (!$model->save()) {
                return false;
            }
        }

        return true;
    }
}