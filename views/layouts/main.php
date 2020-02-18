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

    <link rel="stylesheet" href="/css/site.css">
</head>
<body>
<?php $this->beginBody() ?>

<?php
\yii\bootstrap4\NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-expand-lg navbar-dark blue-gradient',
    ],
]);

$menuItems = [
    '<li class="nav-item">'
    .Html::a('<i class="fas fa-home"></i>', [Yii::$app->homeUrl], ['class' => 'nav-link waves-effect waves-light'])
    . '</li>'
];
if (Yii::$app->user->isGuest) {
    echo '';
} else {
    if (Yii::$app->user->identity->username == 'admin') {
        $menuItems[] = '<li class="nav-item">'
            .Html::a('<i class="fas fa-cogs"></i>', ['/chart/index'], ['class' => 'nav-link waves-effect waves-light'])
            . '</li>';
        $menuItems[] = '<li class="nav-item">'
            .Html::a('<i class="fas fa-users"></i>', ['/user/index'], ['class' => 'nav-link waves-effect waves-light'])
            . '</li>';
    }

    $chartPages = \app\models\ChartPage::find()->all();
    $pageItems = [];
    foreach ($chartPages as $chartPage) {
        $pageItems[] = ['label' => $chartPage->title, 'url' => ['/chart/chart-page?id='.$chartPage->id], 'options' => ['class' => 'btn btn-primary']];
    }
    $menuItems[] = ['label' => '<i class="fas fa-chart-line"></i>', 'items' => $pageItems, 'encode' => false];

    $menuItems[] = '<li class="nav-item">'
        .Html::a('('. Yii::$app->user->identity->username .')'.'<i class="fas fa-sign-out-alt"></i>', ['/site/logout'], ['class' => 'nav-link waves-effect waves-light'])
        . '</li>';
}
echo \yii\bootstrap4\Nav::widget([
    'options' => ['class' => 'navbar-nav ml-auto'],
    'items' => $menuItems,
]);

\yii\bootstrap4\NavBar::end();
?>

<div class="container pt-3">
    <?= $content ?>
</div>

<!-- jQuery -->
<script type="text/javascript" src="/js/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="/js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="/js/mdb.min.js"></script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
