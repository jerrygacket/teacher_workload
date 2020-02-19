<?php
namespace app\controllers\actions;

class IndexAction extends \yii\base\Action
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
        $provider = $component->getDataProvider(\Yii::$app->request->queryParams);

//        if (!$this->rbac->canCreateActivity()){
//            //throw new HttpException(403,'No access to create activity')
//            return \Yii::$app->runAction('auth/signin');
//        }

        return $this->controller->render('index', ['provider'=>$provider]);
    }
}