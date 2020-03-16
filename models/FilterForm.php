<?php


namespace app\models;


use yii\base\Model;

class FilterForm extends Model
{
    public $currentYear;
    public $institute;
    public $department;

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['institute', 'trim'],
            ['department', 'trim'],
            ['currentYear', 'trim'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'institute' => \Yii::t('app', 'Institute'),
            'department' => \Yii::t('app', 'Department'),
            'currentYear' => \Yii::t('app', 'Current year'),
        ];
    }
}