<?php



/* @var $this \yii\web\View */
/* @var $model \app\models\Users|null */
?>

<section class="mt-3">
    <h4 class="card-title">Создать пользователя</h4>
    <?= $this->render('_form-create',['model' => $model]); ?>
</section>