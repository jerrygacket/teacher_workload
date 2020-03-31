<?php
namespace app\controllers\actions;

use app\components\RbacComponent;

class DeleteAction extends \yii\base\Action
{
    /**
     * @var $rbac RbacComponent
     */
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
        if (!$this->rbac->canCreateCatalog()){
            //throw new HttpException(403,'No access to create activity')
            return $this->controller->redirect(['/auth/login']);
        }
        $component = \Yii::createObject(['class' => $this->component, 'nameClass' => $this->model]);
        if ($component->delete(\Yii::$app->request->queryParams)) {
            return $this->controller->redirect('index');
        }

        return $this->controller->render('/site/error',['name' => 'Ошибка удаления', 'message' => 'Не удалось удалить '.$this->model]);
    }
}