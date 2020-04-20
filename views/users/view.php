<?php



/* @var $this \yii\web\View */
/**
 * @var $model \app\models\Users
 * @var $positions \app\models\base\UserPositions[]
 */

use yii\helpers\Html;
$positions = \app\models\base\Position::find()->all();
$occupations = \app\models\base\Occupation::find()->all();
$rates = \app\models\base\Rate::find()->all();
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
        <ul class="list-group list-group-flush">
            <?php foreach ($model->getPositions() as $item) { ?>
                <li class="list-group-item pt-0 pb-0">
                    <?php $form=\yii\bootstrap4\ActiveForm::begin([
                        'method' => 'POST',
                        'action' => Yii::$app->homeUrl.'users/delete-position',
                        'options' => ['class' => '']
                    ]) ?>
                    <?= $form->field($item,'id')->hiddenInput()->label(false) ?>
                    <?= $form->field($item,'userId')->hiddenInput()->label(false) ?>
                    <?= $form->field($item,'positionId')->hiddenInput()->label(false) ?>
                    <?= $form->field($item,'rateId')->hiddenInput()->label(false) ?>
                    <?= $form->field($item,'occupationId')->hiddenInput()->label(false) ?>
                    <?php
                    if ($item->positionId) {
                        echo 'Должность: '. \app\models\base\Position::find()->where(['id' => $item->positionId])->one()['name'];
                    }
                    if ($item->occupationId) {
                        echo ', Ставка: '. \app\models\base\Occupation::find()->where(['id' => $item->occupationId])->one()['name'];
                    }
                    if ($item->rateId) {
                        echo ', Размер ставки: '. \app\models\base\Rate::find()->where(['id' => $item->rateId])->one()['name'];
                    }
                    ?>
                    <?= Html::submitButton(
                        '<i class="fas fa-times"></i>',
                        [
                            'class' => 'btn btn-link m-0 red-text p-1',
                            'title' => 'Удалить',
                            'onclick' => 'if(confirm("Хотите удалить?")){
                                         return true;
                                        }else{
                                         return false;
                                        }',
                        ]
                    ); ?>
                    <?php \yii\bootstrap4\ActiveForm::end() ?>
                </li>
            <?php } ?>
        </ul>
        <br>
        <?= $this->render('_positionForm',['userId' => $model->id]); ?>
        <hr>
    </div>
</div>