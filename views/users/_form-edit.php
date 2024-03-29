<?php



/* @var $this \yii\web\View */
/* @var $model \app\models\Users */

$form = \yii\bootstrap4\ActiveForm::begin([
    'id' => 'user-edit-form',
    'method' => 'POST',
    'action' => Yii::$app->homeUrl.'users/edit',
    'options' => ['class' => '']
]);
echo $form->field($model,'id')->hiddenInput()->label(false);
?>

<div class="row">
    <div class="col-md-6 col-12">
        <?php
        if (Yii::$app->user->identity->username == 'admin') {
            echo $form->field($model, 'username', ['enableClientValidation'=>false,
                'enableAjaxValidation'=>true])
                ->textInput(['required'=>true]);
            echo $form->field($model, 'password', ['enableClientValidation'=>false,
            'enableAjaxValidation'=>true])
            ->passwordInput([]);
        }
        ?>
        <?=$form->field($model, 'surname')->textInput(); ?>
        <?=$form->field($model, 'name')->textInput(); ?>
        <?=$form->field($model, 'middleName')->textInput(); ?>
        <?=$form->field($model, 'email')->textInput(); ?>
        <?php
        if (Yii::$app->user->identity->username == 'admin') {
            ?>
            <div class="custom-control custom-checkbox">
                <?= $form->field($model, 'active', ['options' => ['tag' => false,]])
                    ->checkbox([
                        //'checked' => isset($model->active) ? $model->active : true,
                        'template' => '{input}{label}',
                        'class' => 'custom-control-input'
                    ], false)
                    ->label('Активный пользователь', ['class' => 'custom-control-label']); ?>
            </div>
            <?php
        } else {
            $model->active = true;
            echo $form->field($model,'active')->hiddenInput()->label(true);
        }
        ?>
        <div class="custom-control custom-checkbox">
            <?= $form->field($model, 'teacher', ['options' => ['tag' => false,]])
                ->checkbox([
                    'template' => '{input}{label}',
                    'class' => 'custom-control-input'
                ], false)
                ->label('Учавствует в распределении нагрузки', ['class' => 'custom-control-label']); ?>
        </div>
        <div class="custom-control custom-checkbox">
            <?= $form->field($model, 'top', ['options' => ['tag' => false,]])
                ->checkbox([
                    'template' => '{input}{label}',
                    'class' => 'custom-control-input'
                ], false)
                ->label('Высшее руководство', ['class' => 'custom-control-label']); ?>
        </div>
    </div>
    <div class="col-md-6 col-12">
        <?= $form->field($model,'departmentId')->dropDownList(
            \yii\helpers\ArrayHelper::map(
                \app\models\Departments::find()
                    ->all(),'id','fullName'
            ),
            [
                'prompt' => 'Выберите кафедру...'
            ]
        ); ?>
        <?php
//        if (Yii::$app->user->identity->username == 'admin') {
//            echo $form->field($model,'departmentId')->dropDownList(
//                \yii\helpers\ArrayHelper::map(
//                    \app\models\Departments::find()
//                        ->all(),'id','fullName'
//                ),
//                [
//                    'prompt' => 'Выберите кафедру...'
//                ]
//            );
//        } else {
//            $model->departmentId = \Yii::$app->user->departmentId;
//            echo $form->field($model,'departmentId')->hiddenInput()->label(false);
//            echo 'Кафедра: '.$model->getDepartment()->one();
//        }
        ?>

        <?= $form->field($model,'degreeId')->dropDownList(
            \yii\helpers\ArrayHelper::map(
                \app\models\base\Degree::find()
                    ->all(),'id','name'
            ),
            [
                'prompt' => 'Выберите степень...'
            ]
        ); ?>
        <?= $form->field($model,'rankId')->dropDownList(
            \yii\helpers\ArrayHelper::map(
                \app\models\base\Rank::find()
                    ->all(),'id','name'
            ),
            [
                'prompt' => 'Выберите звание...'
            ]
        ); ?>
        <?= $this->render('_positionFormJs',['model' => $model, 'form' => true]); ?>
    </div>
</div>
    <div class="form-group">
        <button class="btn btn-success" type="submit">Сохранить</button>
        <?= \yii\helpers\Html::a('Отмена',['/users/index'], ['class' => 'btn btn-danger'])?>
    </div>
<?php \yii\bootstrap4\ActiveForm::end(); ?>