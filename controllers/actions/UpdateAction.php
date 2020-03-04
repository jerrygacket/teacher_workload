<?php
namespace app\controllers\actions;

class UpdateAction extends \yii\base\Action
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
        //        if (!$this->rbac->canCreateActivity()){
//            //throw new HttpException(403,'No access to create activity')
//            return \Yii::$app->runAction('auth/signin');
//        }
        $component = \Yii::createObject(['class' => $this->component, 'nameClass' => $this->model]);
        if ($component->updateFromFB()) {
            $provider = $component->getDataProvider(\Yii::$app->request->queryParams);
            return $this->controller->redirect('index');
        }

        return $this->controller->render('error');
    }
}