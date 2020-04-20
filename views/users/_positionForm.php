<?php
/* @var $this \yii\web\View */
/**
 * @var $userId integer
 */
$positions = \app\models\base\Position::find()->all();
$occupations = \app\models\base\Occupation::find()->all();
$rates = \app\models\base\Rate::find()->all();
$model = new \app\models\base\UserPositions();
$model->userId = $userId;

$form=\yii\bootstrap4\ActiveForm::begin([
    'id' => 'position-create-form',
    'method' => 'POST',
    'action' => Yii::$app->homeUrl.'users/add-position',
    'options' => ['class' => '']
]);
echo $form->field($model,'userId')->hiddenInput()->label(false)
?>
    <div class="form-row row">
        <div class="col-xl-3 col-12 text-md-center m-auto">
            <?= $form->field($model,'positionId')->dropDownList(
                \yii\helpers\ArrayHelper::map(
                    $positions,'id','name'
                ),
                [
                    'prompt' => 'Должность...'
                ]
            )->label(false)?>
        </div>
        <div class="col-xl-3 col-12 text-md-center m-auto">
            <?= $form->field($model,'occupationId')->dropDownList(
                \yii\helpers\ArrayHelper::map(
                    $occupations,'id','name'
                ),
                [
                    'prompt' => 'Ставка...',
                    'onchange' => 'selectOccupation(this)'
                ]
            )->label(false)?>
        </div>
        <div class="col-xl-2 col-12 text-md-center m-auto">
            <div id="rateSelect">
                <?= $form->field($model,'rateId')->dropDownList(
                    \yii\helpers\ArrayHelper::map(
                        $rates,'id','name'
                    ),
                    [
                        'prompt' => 'Разммер ставки...'
                    ]
                )->label(false)?>
            </div>
        </div>
        <div class="col-xl-3 col-12 text-md-center">
            <?= \yii\helpers\Html::submitButton('Добавить', ['class' => 'btn btn-sm blue-gradient w-100 ml-0']); ?>
        </div>
    </div>
<?php \yii\bootstrap4\ActiveForm::end(); ?>