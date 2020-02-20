<?php
/**
 * @var $this \yii\web\View
 * @var $provider \yii\data\ActiveDataProvider
 *
 */

use yii\helpers\Html; ?>
<?= Html::a('Создать пользователя', '/users/create', ['class' => 'btn blue-gradient']) ?>
<?=\yii\grid\GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        'id:html',
        'surname:html',
        'name:html',
        'middleName:html',
        [
            'class' => '\yii\grid\ActionColumn',
            'header' => 'Действия',
            'template' => '{edit} &nbsp;&nbsp; {delete}',
            'controller' => 'Users',
            'buttons' => [
                'edit' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-edit"></i>', $url);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-times" style="color:red"></i>', $url,[
                        'onclick' => 'if(confirm("Хотите удалить?")){
                                         return true;
                                        }else{
                                         return false;
                                        }',
                    ]);
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
<?= Html::a('Создать пользователя', '/users/create', ['class' => 'btn blue-gradient']) ?>