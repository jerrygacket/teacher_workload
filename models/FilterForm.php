<?php


namespace app\models;


use yii\base\Model;

class FilterForm extends Model
{
    const YEARS = [
        '2018' => '2018',
        '2019' => '2019',
        '2020' => '2020',
        '2021' => '2021',
        '2022' => '2022',
        '2023' => '2023',
    ];

    public $currentYear = '2019';
    public $institute;
    public $department;
    public $semester;

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['institute', 'trim'],
            ['department', 'trim'],
            ['currentYear', 'trim'],
            ['semester', 'trim'],
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
            'semester' => \Yii::t('app', 'Semester'),
        ];
    }
}