<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- MDB icon -->
    <link rel="icon" href="/img/mdb-favicon.ico" type="image/x-icon">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="/css/mdb.min.css">

    <!-- Docs for tables -> https://datatables.net-->
    <link rel="stylesheet" href="/css/addons/datatables.min.css">

    <link rel="stylesheet" href="/css/site.css">
</head>
<body>
<?php //$this->beginBody() ?>

<?php
\yii\bootstrap4\NavBar::begin([
    'brandLabel' => $this->params['h1'] ?? Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-expand-lg navbar-dark blue-gradient',
    ],
]);

$menuItems = [
    '<li class="nav-item">'
    .Html::a('<i class="fas fa-home"></i>', [Yii::$app->homeUrl],
        [
            'class' => 'nav-link waves-effect waves-light',
            'title' => 'На главную',
            'data-toggle' => 'tooltip',
        ])
    . '</li>'
];
if (Yii::$app->user->isGuest) {
    echo '';
} else {
    if (Yii::$app->user->identity->username == 'admin') {
        $menuItems[] = '<li class="nav-item">'
            .Html::a('<i class="fas fa-cogs"></i>', ['/site/about'],
                [
                    'class' => 'nav-link waves-effect waves-light',
                    'title' => 'Настройки',
                    'data-toggle' => 'tooltip',
                ])
            . '</li>';
        $menuItems[] = '<li class="nav-item">'
            .Html::a('<i class="fas fa-users"></i>', ['/users/index'],
                [
                    'class' => 'nav-link waves-effect waves-light',
                    'title' => 'Пользователи',
                    'data-toggle' => 'tooltip',
                ])
            . '</li>';
    }
//    $menuItems[] = '<li class="nav-item">'
//        .Html::a(
//                '<i class="far fa-calendar-alt"></i>',
//                ['/load/kaf-load'],
//                [
//                    'class' => 'nav-link waves-effect waves-light',
//                    'title' => 'Общекафедральная нагрузка',
//                    'data-toggle' => 'tooltip',
//                ]
//        )
//        . '</li>';

    $menuItems[] = '<li class="nav-item">'
        .Html::a(
                '('. Yii::$app->user->identity->username .')'.'<i class="fas fa-sign-out-alt"></i>',
                ['/auth/logout'],
            [
                'class' => 'nav-link waves-effect waves-light',
                'title' => 'Выход',
                'data-toggle' => 'tooltip',
            ])
        . '</li>';
}
echo \yii\bootstrap4\Nav::widget([
    'options' => ['class' => 'navbar-nav ml-auto'],
    'items' => $menuItems,
]);

\yii\bootstrap4\NavBar::end();
?>

<div class="container<?= isset($this->params['wide']) && $this->params['wide'] ? '-fluid' : '' ?> pt-3">
    <?= $content ?>
</div>

<!-- Footer -->
<footer class="page-footer font-small blue">
    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© <?=date('Y') == '2020' ? '2020' : '2020 - '.date('Y') ?> Copyright:
        <a href="https://mdbootstrap.com/"> IvGPU</a>
    </div>
    <!-- Copyright -->

</footer>
<!-- Footer -->
<?php //$this->endBody() ?>
<!-- jQuery -->
<script type="text/javascript" src="/js/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="/js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="/js/mdb.min.js"></script>

<!-- Docs for tables -> https://datatables.net-->
<script type="text/javascript" src="/js/addons/datatables.min.js"></script>
<script type="text/javascript" src="/js/addons/datatables-select.min.js"></script>
<script type="text/javascript" src="/js/tableSort.js"></script>
<script type="text/javascript" src="/js/actions.js"></script>

</body>
</html>
<?php $this->endPage() ?>
