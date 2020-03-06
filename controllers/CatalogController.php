<?php


namespace app\controllers;


use app\base\BaseController;
use app\components\CatalogComponent;
use app\models\Catalog;
use Yii;
use yii\db\Query;

class CatalogController extends BaseController
{
    /**
     * @var CatalogComponent
     */
    public $component;

    public function actionIndex() {
        $this->component = Yii::createObject(['class' => CatalogComponent::class, 'nameClass' => Catalog::class]);

        return $this->render('index',['catalogs' => $this->component->getCatalogs()]);
    }

    public function actionAdd() {
        $tableName = Yii::$app->request->getBodyParam('table', null);
        $data = Yii::$app->request->getBodyParam('name', null);
        if (Yii::$app->request->isPost && $tableName && $data && Yii::$app->db->schema->getTableSchema($tableName)) {
            Yii::$app->db->createCommand()->insert($tableName, ['name' => $data])->execute();
        }

        return $this->redirect('/catalog');
    }

    public function actionDelete() {
        $tableName = Yii::$app->request->getBodyParam('table', null);
        $data = Yii::$app->request->getBodyParam('name', null);
        if (Yii::$app->request->isPost && $tableName && $data && Yii::$app->db->schema->getTableSchema($tableName)) {
            Yii::$app->db->createCommand()->delete($tableName, ['name' => $data])->execute();
        }

        return $this->redirect('/catalog');
    }

    public function actionKafLoad() {
        $tableName = Yii::$app->request->getBodyParam('table', null);
        $data = Yii::$app->fbDb->createCommand('select * from NAGR2016 where CUR_YEAR = 2019')
            ->queryAll();
        $data = mb_check_encoding($data, 'UTF-8') ? $data : mb_convert_encoding($data, 'UTF-8', 'CP1251');

        return $this->render('kafLoad', ['data' => $data]);
    }
}