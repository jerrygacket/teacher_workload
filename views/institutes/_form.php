<?php



/* @var $this \yii\web\View */
/* @var $model \app\models\Institutes */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$form=ActiveForm::begin([
    'options' => [
        'action'=>'/institutes/edit','enctype' => 'multipart/form-data'
    ]
]);

echo $form->field($model,'id')->hiddenInput()->label(false);

echo $form->field($model,'name');
echo $form->field($model,'fullName');

// TODO: может ли один человек быть директором на нескольких институтах?
echo $form->field($model,'headId')->dropDownList(
    \yii\helpers\ArrayHelper::map(
        \app\models\Users::find()
            ->where([
                'active'=>true,
                'top'=>true,
            ])
            ->all(),'id','fullName'
    ),
    [
        'prompt' => 'Выберите директора...'
    ]
);
?>

    <div class="form-group">
        <button class="btn btn-success" type="submit">Сохранить</button>
        <?= Html::a('Отмена',['/institutes/index'], ['class' => 'btn btn-danger'])?>
    </div>
<?php ActiveForm::end(); ?>