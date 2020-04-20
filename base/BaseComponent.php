<?php


namespace app\base;


use app\models\base\Users;
use yii\base\Component;
use yii\data\ActiveDataProvider;

class BaseComponent extends Component
{
    public $nameClass;

    public function init()
    {
        parent::init();

        if (empty($this->nameClass)){
            throw new \Exception('no ClassName');
        }
    }

    public function getDataProvider($params = []) {
        $model = new $this->nameClass;

        $query = $model::find()->where($params);
//        print_r($query);
//        \Yii::$app->end(0);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id'=>SORT_DESC
                ]
            ]
        ]);

        return $provider;
    }

    public function getModel($params = []) {
        $model = new $this->nameClass;

        return empty($params['id']) ? $model : $model::findOne(['id'=>$params['id']]);
    }

    public function getDataFromFB($tableName) {
        $data = \Yii::$app->fbDb->createCommand('select 1 from RDB$RELATIONS WHERE RDB$RELATION_NAME = \''.$tableName.'\'')
            ->queryAll();
        if (empty($data)) {
            return false;
        }

        $data = \Yii::$app->fbDb->createCommand('select * from '.$tableName.' where CUR_YEAR = '.date('Y'))
            ->queryAll();

        // данные почему-то хранятся в кодировке Windows-1251!!!!!!
        $data = mb_check_encoding($data, 'UTF-8') ? $data : mb_convert_encoding($data, 'UTF-8', 'CP1251');

        return $data;
    }

    public function delete($params = []) {
        $model = $this->getModel($params);

        return $model->delete();
    }
}