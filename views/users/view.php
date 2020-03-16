<?php



/* @var $this \yii\web\View */
/**
 * @var $model \app\models\Users
 */
?>
<div class="row">
    <div class="col-12">
        <h1>Пользователь</h1>

        <?= \yii\widgets\DetailView::widget([
            'model' => $model,
            'attributes' => [
                'username',                                           // title свойство (обычный текст)
                'email:html',                                // description свойство, как HTML
                [                                                  // name свойство зависимой модели owner
                    'label' => 'Институт',
                    'value' => $model->department->name ?? 'Не назначен',
                    'contentOptions' => ['class' => 'bg-red'],     // настройка HTML атрибутов для тега, соответсвующего value
                    'captionOptions' => ['tooltip' => 'Tooltip'],  // настройка HTML атрибутов для тега, соответсвующего label
                ],
            ],
        ]) ?>

    </div>
</div>