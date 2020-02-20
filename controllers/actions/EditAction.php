<?php
namespace app\controllers\actions;

class EditAction extends \yii\base\Action
{
    public $rbac;
    public $component;
    public $model;

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function run()
    {
        $component = \Yii::createObject(['class' => $this->component, 'nameClass' => $this->model]);
        $model = $component->getModel(\Yii::$app->request->queryParams);
//        if (!$this->rbac->canCreateActivity()){
//            //throw new HttpException(403,'No access to create activity')
//            return \Yii::$app->runAction('auth/signin');
//        }

        return $this->controller->render('edit', ['model'=>$model]);
    }
}