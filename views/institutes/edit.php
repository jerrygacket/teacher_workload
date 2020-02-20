<?php



/* @var $this \yii\web\View */

?>
<div class="row">
    <div class="col-12">
        <?= $model->id ? '<h1>Редактировать запись</h1>' : '<h1>Создать запись</h1>' ?>

        <?= $this->render('_form',['model' => $model]); ?>

    </div>
</div>