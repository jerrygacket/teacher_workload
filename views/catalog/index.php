<?php

/**
 * @var $this \yii\web\View
 * @var $catalogs
 */

use yii\helpers\Html;

?>
<div class="row">
    <?php
    foreach ($catalogs as $name => $catalog) {
    ?>
        <div class="col-md-4 col-12 mb-5">
            <h2><?= Html::encode($name) ?></h2>
            <ul class="list-group list-group-flush">
            <?php foreach ($catalog['rows'] as $item) { ?>
                    <li class="list-group-item">
                        <?= Html::beginForm(['/catalog/delete'], 'POST', ['class' => 'form-inline']); ?>
                        <?= $item['name'] ?>
                        <?= Html::input('hidden', 'table', $catalog['table']); ?>
                        <?= Html::input('hidden', 'name', $item['name']); ?>
                        <?= Html::submitButton('<i class="fas fa-times"></i>', ['class' => 'btn btn-link']); ?>
                        <?= Html::endForm(); ?>
                    </li>
            <?php } ?>
            </ul>
            <br>
            <?= Html::beginForm(['/catalog/add'], 'POST', ['class' => '']); ?>
            <?= Html::input('hidden', 'table', $catalog['table']); ?>
            <div class="form-row">
                <div class="col-xl-8 col-12">
                    <?= Html::input('text', 'name', null, ['class' => 'form-control']); ?>
                </div>
                <div class="col-xl-4 col-12 text-md-center">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-sm blue-gradient w-100 ml-0']); ?>
                </div>
            </div>
            <?= Html::endForm(); ?>
            <hr>
        </div>
    <?php } ?>
</div>