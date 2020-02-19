<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Расчет индивидуальной нагрузки</h1>

        <p class="lead">Для расчета надо добавить институты и кафедры</p>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-md-3 col-12">
                <h2>Справочники</h2>

                <p>Описание (кратко)</p>
                <p><a class="btn peach-gradient" href="/catalog">Посмотреть</a></p>
            </div>
            <div class="col-md-3 col-12">
                <h2>Институты</h2>

                <p>Институты</p>
                <p><a class="btn peach-gradient" href="/institutes">Посмотреть</a></p>
            </div>
            <div class="col-md-3 col-12">
                <h2>Кафедры</h2>

                <p>Кафедры</p>
                <p><a class="btn peach-gradient" href="/departments">Посмотреть</a></p>
            </div>
            <div class="col-md-3 col-12">
                <h2>Пользователи</h2>

                <p>Пользователи</p>
                <p><a class="btn peach-gradient" href="/users">Посмотреть</a></p>
            </div>
        </div>

    </div>
</div>
