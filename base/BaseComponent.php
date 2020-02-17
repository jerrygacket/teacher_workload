<?php


namespace app\base;


use yii\base\Component;

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
}