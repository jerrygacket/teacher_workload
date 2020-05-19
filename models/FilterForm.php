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
    public $emptyUser;
    public $teacher;

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['institute', 'trim'],
            ['department', 'trim'],
            ['currentYear', 'trim'],
            ['semester', 'trim'],
            ['emptyUser', 'trim'],
            ['teacher', 'trim'],
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
            'emptyUser' => \Yii::t('app', 'Empty User'),
            'teacher' => \Yii::t('app', 'Teacher'),
        ];
    }
}