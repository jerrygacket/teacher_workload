<?php



/* @var $this \yii\web\View */
/* @var $model mixed */
use yii\widgets\ActiveForm;


$form = ActiveForm::begin([
    'id' => 'login-form',
    'method' => 'POST',
    'action' => '/auth/login',
    'fieldConfig' => [
        'template' => "{input}\n{label}\n{hint}\n{error}",
    ],
    'options' => ['class' => '']
]);
?>
    <p class="h4 mb-4 text-center">Вход</p>
<?php
if (Yii::$app->session->hasFlash('userError')) {
    echo '<div class="alert alert-danger" role="alert">'.Yii::$app->session->getFlash('userError').'</div>';
}
?>
    <div class="md-form mb-5">
        <i class="fas fa-user prefix grey-text"></i>
        <?=$form->field($model, 'username', ['options' => ['tag' => false,]])
            ->textInput(['required'=>true, 'class' => 'form-control validate ml-5', 'style' => 'color:#495057;'])
            ->label('Логин'); ?>
    </div>

    <div class="md-form mb-4">
        <i class="fas fa-lock prefix grey-text"></i>
        <?=$form->field($model, 'password', ['options' => ['tag' => false,]])
            ->passwordInput(['required'=>true, 'class' => 'form-control validate ml-5', 'style' => 'color:#495057;'])
            ->label('Пароль'); ?>
    </div>

    <div>
        <!-- Remember me -->
        <div class="custom-control custom-checkbox">
            <?= $form->field($model, 'rememberMe', ['options' => ['tag' => false,]])
                ->checkbox([
                    'template' => '{input}{label}',
                    'class' => 'custom-control-input'
                ], false)
                ->label('Запомнить меня', ['class' => 'custom-control-label']); ?>
        </div>
    </div>

    <!-- Sign in button -->
    <div class="text-center">
        <button class="btn btn-info my-4" type="submit">Вход</button>
    </div>

<?php ActiveForm::end(); ?>