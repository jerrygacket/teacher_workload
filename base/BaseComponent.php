<?php


namespace app\base;


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

    public function getDataProvider($params) {
        $model = new $this->nameClass;
        $model->load($params);

        $query = $model::find();

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100
            ],
            'sort' => [
                'defaultOrder' => [
                    'id'=>SORT_DESC
                ]
            ]
        ]);

        return $provider;
    }
}