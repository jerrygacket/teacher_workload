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
        <div class="col-md-4 col-12">
            <h2><?= Html::encode($name) ?></h2>
            <ul class="list-group list-group-flush">
            <?php foreach ($catalog['rows'] as $item) { ?>
                    <li class="list-group-item"><?= $item['name'] ?></li>
            <?php } ?>
            </ul>
            <br>
            <?= Html::beginForm(['/catalog/add'], 'POST'); ?>
            <?= Html::input('hidden', 'table', $catalog['table']); ?>
            <?= Html::input('text', 'name'); ?>
            <div class="form-group">
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']); ?>
            </div>
            <?= Html::endForm(); ?>
        </div>
    <?php } ?>
</div>