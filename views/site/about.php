<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'О приложении';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <pre>
    <?=print_r($data,true)?>
        </pre>
    <p>
        Здесь будут настройки приложения
    </p>

</div>
