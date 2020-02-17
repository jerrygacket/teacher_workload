<?php


namespace app\components;


use app\base\BaseComponent;
use app\models\Catalog;
use yii\db\Query;

/**
 *
 * @property array $catalogs
 */
class CatalogComponent extends BaseComponent
{
    public function getModel($params=[]) {
        $model = new $this->nameClass;

        if (empty($params['id'])) {
            return $model;
        }

        return $model::findOne(['id'=>$params['id']]);
    }

    public function getCatalogs(){
        $catalogs = Catalog::find()->all();
        $rows = [];
        foreach ($catalogs as $catalog) {
            if (!$catalog->modelName) {
                $rows[$catalog->name]['rows'] = $this->getCatalog($catalog->tableName);
                $rows[$catalog->name]['table'] = $catalog->tableName;
            }
        }

        return $rows;
    }

    public function getCatalog($tableName) {
        $rows = new Query;
        return $rows->select('name')->from($tableName)->all();
    }
}