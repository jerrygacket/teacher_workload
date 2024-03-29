<?php
/**
 * @var $this \yii\web\View
 * @var $provider \yii\data\ActiveDataProvider
 *
 */

use yii\helpers\Html; ?>
<?= Html::a('Добавить', '/catalog/create', ['class' => 'btn btn-primary']) ?>
<?=\yii\grid\GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        'id:html',
        'name:html',
        [
            'attribute' => 'created_on',
            'format' =>  ['date', 'HH:mm:ss dd.MM.Y'],
        ],
        [
            'attribute' => 'updated_on',
            'format' =>  ['date', 'HH:mm:ss dd.MM.Y'],
        ],
        [
            'class' => '\yii\grid\ActionColumn',
            'header' => 'Действия',
            'template' => '{view}&nbsp;&nbsp; {create} &nbsp;&nbsp; {delete}',
            'controller' => 'catalog',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-eye"></i>', $url);
                },
                'create' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-edit"></i>', $url);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-times" style="color:red"></i>', $url);
                },
            ]
        ],
    ],
    'pager' => [
        'options'=>['class'=>'pagination pg-teal justify-content-center'],   // set clas name used in ui list of pagination
//        'disableCurrentPageButton' => 'true',
        'disabledPageCssClass' => 'disabled',
        'disabledListItemSubTagOptions' => [
            'tag' => 'a',
            'class' => 'page-link',
        ],
        'linkContainerOptions' => [
            'class' => 'page-item',
        ],
        'prevPageLabel' => '<',   // Set the label for the “previous” page button
        'nextPageLabel' => '>',   // Set the label for the “next” page button
        'firstPageLabel'=>'<<',   // Set the label for the “first” page button
        'lastPageLabel'=>'>>',    // Set the label for the “last” page button
//        'nextPageCssClass'=>'page-item',    // Set CSS class for the “next” page button
//        'prevPageCssClass'=>'page-item',    // Set CSS class for the “previous” page button
//        'firstPageCssClass'=>'page-item',    // Set CSS class for the “first” page button
//        'lastPageCssClass'=>'page-item',    // Set CSS class for the “last” page button
        'maxButtonCount'=>10,    // Set maximum number of page buttons that can be displayed
        'linkOptions' => [
            'class' => 'page-link'
        ]
    ],
])
?>
<?= Html::a('Добавить', '/catalog/create', ['class' => 'btn btn-primary']) ?>

