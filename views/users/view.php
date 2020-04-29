<?php



/* @var $this \yii\web\View */
/**
 * @var $model \app\models\Users
 * @var $positions \app\models\base\UserPositions[]
 */

use yii\helpers\Html;

?>
<div class="row">
    <div class="col-12">
        <h1>Пользователь</h1>

        <?= \yii\widgets\DetailView::widget([
            'model' => $model,
            'attributes' => [
                'surname:html',
                'name:html',
                'middleName:html',
                'teacher:html',
                'top:html',
                'email:html',                                // description свойство, как HTML
                'username',                                           // title свойство (обычный текст)
                [                                                  // name свойство зависимой модели owner
                    'label' => 'Институт',
                    'value' => $model->getInstitute()['fullName'] ?? 'Не назначен',
                    'contentOptions' => ['class' => 'bg-red'],     // настройка HTML атрибутов для тега, соответсвующего value
                    'captionOptions' => ['tooltip' => 'Tooltip'],  // настройка HTML атрибутов для тега, соответсвующего label
                ],
                [                                                  // name свойство зависимой модели owner
                    'label' => 'Кафедра',
                    'value' => $model->department->fullName ?? 'Не назначен',
                    'contentOptions' => ['class' => 'bg-red'],     // настройка HTML атрибутов для тега, соответсвующего value
                    'captionOptions' => ['tooltip' => 'Tooltip'],  // настройка HTML атрибутов для тега, соответсвующего label
                ],
                [                                                  // name свойство зависимой модели owner
                    'label' => 'Звание',
                    'value' => $model->rank->name ?? 'Нет звания',
                    'contentOptions' => ['class' => 'bg-red'],     // настройка HTML атрибутов для тега, соответсвующего value
                    'captionOptions' => ['tooltip' => 'Tooltip'],  // настройка HTML атрибутов для тега, соответсвующего label
                ],
                [                                                  // name свойство зависимой модели owner
                    'label' => 'Степень',
                    'value' => $model->degree->name ?? 'Нет степени',
                    'contentOptions' => ['class' => 'bg-red'],     // настройка HTML атрибутов для тега, соответсвующего value
                    'captionOptions' => ['tooltip' => 'Tooltip'],  // настройка HTML атрибутов для тега, соответсвующего label
                ],
            ],
        ]) ?>

    </div>
    <div class="col-12">
        <h2>Должности:</h2>
        <?= $this->render('_positionFormJs',['model' => $model, 'form' => false]); ?>
    </div>
</div>