<?php

/* @var $this yii\web\View */
$this->title = 'Главная';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Расчет индивидуальной нагрузки</h1>
        <p>Здесь текст описание... Или ссылки на документы</p>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-md-3 col-12">
                <a class="btn btn-primary" href="/catalog">Справочники</a>
            </div>
            <div class="col-md-3 col-12">
                <a class="btn btn-success" href="/load/kaf-load">Общая нагрузка</a>
            </div>
            <div class="col-md-3 col-12">
                <p><a class="btn btn-info" href="/institutes">Институты</a></p>
            </div>
            <div class="col-md-3 col-12">
                <p><a class="btn btn-info" href="/departments">Кафедры</a></p>
            </div>
            <div class="col-md-3 col-12">
                <p><a class="btn btn-primary" href="/users">Пользователи</a></p>
            </div>
        </div>

    </div>
</div>
