<?php



/* @var $this \yii\web\View */
/* @var $model \app\models\Departments */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$form=ActiveForm::begin([
    'options' => [
        'action'=>'/departments/edit','enctype' => 'multipart/form-data'
    ]
]);

echo $form->field($model,'id')->hiddenInput()->label(false);

echo $form->field($model,'name');
echo $form->field($model,'fullName');

// TODO: может ли один человек быть завкафом на нескольких кафедрах?
// TODO: то же самое и к директорам
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
        'prompt' => 'Выберите заведующего...'
    ]
);

echo $form->field($model,'instituteId')->dropDownList(
    \yii\helpers\ArrayHelper::map(
        \app\models\Institutes::find()
            ->all(),'id','fullName'
    ),
    [
        'prompt' => 'Выберите институт...'
    ]
);
?>

    <div class="form-group">
        <button class="btn btn-success" type="submit">Сохранить</button>
        <?= Html::a('Отмена',['/departments/index'], ['class' => 'btn btn-danger'])?>
    </div>
<?php ActiveForm::end(); ?>