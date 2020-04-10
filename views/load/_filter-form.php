<?php

/**
 * @var $filterForm \app\models\FilterForm
 */

use app\models\Departments;
use app\models\Institutes;

$form = \yii\widgets\ActiveForm::begin([
    'id' => 'login-form',
    'options' => [
        'class' => 'form-horizontal',
        'action'=>'/load/'.$action,
        'method' => 'post',
        'enctype' => 'multipart/form-data'
    ],
]);
echo '<hr>';
echo '<div class="row">';

if (!isset($fields) || isset($fields['currentYear'])) {
    echo '<div class="col-md-2 col-12">';
    echo $form->field($filterForm,'currentYear')->dropDownList(
        \app\models\FilterForm::YEARS,
        [
            'prompt' => 'Текущий год',
        ]
    );
    echo '</div>';
}
if (!isset($fields) || isset($fields['institute'])) {
    echo '<div class="col-md-2 col-12">';
    echo $form->field($filterForm,'institute')->dropDownList(
        \yii\helpers\ArrayHelper::map(Institutes::find()->all(), 'SHFAK', 'NFAK'),
        ['prompt' => 'Не выбран...']
    );
    echo '</div>';
}

if (!isset($fields) || isset($fields['department'])) {
    echo '<div class="col-md-2 col-12">';
    echo $form->field($filterForm, 'department')->dropDownList(
        \yii\helpers\ArrayHelper::map(Departments::find()->all(), 'SHKAF', 'NKAF'),
        ['prompt' => 'Не выбрана...']
    );
    echo '</div>';
}

if (!isset($fields) || isset($fields['semester'])) {
    echo '<div class="col-md-2 col-12">';
    echo $form->field($filterForm, 'semester')->dropDownList(
        ['1' => '1', '2' => '2'],
        ['prompt' => 'Не выбран...']
    );
    echo '</div>';
}
echo '<div class="col-md-2 col-12">';
echo \yii\helpers\Html::submitButton('Применить', ['class' => 'btn btn-primary']);
echo '</div>';

echo '</div>';
\yii\widgets\ActiveForm::end();

echo '<hr>';