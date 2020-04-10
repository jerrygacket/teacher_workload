<?php

/* @var $this yii\web\View */
$this->title = 'Главная';
$roles = \Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Расчет индивидуальной нагрузки</h1>
        <p>Здесь текст описание... Или ссылки на документы</p>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-md-6 col-12">
                <h2>Настройки</h2>
                <p><a class="btn btn-primary" href="/users">Пользователи</a></p>
                <p><a class="btn btn-info" href="/institutes">Институты</a></p>
                <p><a class="btn btn-info" href="/departments">Кафедры</a></p>
                <p><a class="btn btn-info" href="/catalog">Справочники</a></p>
            </div>
            <div class="col-md-6 col-12">
                <h2>Расчет</h2>
                <?= !empty($roles['user']) || !empty($roles['admin']) ? '<p><a class="btn btn-outline-blue" href="/load/all-load">Общая нагрузка</a></p>' : ''?>
                <p><a class="btn btn-outline-red" href="/load/kaf-load">Кафедральная нагрузка</a></p>
                <p><a class="btn btn-outline-black" href="/load/calc">Распределение</a></p>
            </div>
        </div>

    </div>
</div>
