<?php


namespace app\components;


use app\base\BaseComponent;
use app\models\Institutes;

/**
 * Class InstitutesComponent
 * @package app\components
 */
class InstitutesComponent extends BaseComponent
{
    /**
     * @var $model Institutes
     * @return mixed
     */
    public function updateFromFB() {
        $newData = $this->getDataFromFB('FAKUL');

        foreach ($newData as $item) {
            $model = $this->nameClass::findOne(['SHFAK'=>$item['SHFAK']]);
            if (empty($model)) {
                $model = new $this->nameClass;
            }
            $model->attributes = $item;
            $model->name = $item['FAK'];
            $model->fullName = $item['NFAK'];

            if (!$model->save()) {
                print_r($model->getErrors());
                \Yii::$app->end();
                return false;
            }
        }

        return true;
    }
}