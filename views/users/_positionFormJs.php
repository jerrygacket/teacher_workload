<?php
/**
 * Список должностей пользователя и форма для добавления должности
 */
/* @var $this \yii\web\View */
$allPositions = \yii\helpers\ArrayHelper::map(
    \app\models\base\Position::find()->all(),'id','name'
);
$allOccupations = \yii\helpers\ArrayHelper::map(
    \app\models\base\Occupation::find()->all(),'id','name'
);
$allRates = \yii\helpers\ArrayHelper::map(
    \app\models\base\Rate::find()->all(),'id','name'
);
?>
<div class="card">
    <div class="card-body">
        <ul class="list-group list-group-flush mb-1" id="positions">
            <?php
            echo $this->render('_user-positions',[
                'userPositions' => $model->getPositions(),
                'allPositions' => $allPositions,
                'allOccupations' => $allOccupations,
                'allRates' => $allRates,
                'form' => (isset($form) && $form)]);
            ?>
        </ul>
        <?php
        if (isset($form) && $form) {
        ?>
        <div class="row">
            <div class="col-12 mb-3">
                <?= \yii\helpers\Html::dropDownList('position',null,
                    $allPositions,
                    [
                        'id' => 'position',
                        'prompt' => 'Должность...',
                    ]
                )?>
            </div>
            <div class="col-12 mb-3">
                <?=  \yii\helpers\Html::dropDownList('occupation',null,
                    $allOccupations,
                    [
                        'id' => 'occupation',
                        'prompt' => 'Ставка...',
                        'onchange' => 'selectOccupation(this)',
                        'data-description' => 'descr',
                    ]
                )?>
            </div>
            <div class="col-12 mb-3" id="rateSelect">
                <?=  \yii\helpers\Html::dropDownList('rate',null,
                    $allRates,
                    [
                        'id' => 'rate',
                        'prompt' => 'Разммер ставки...',
                    ]
                )?>
            </div>
            <div class="col-12 text-md-center">
                <?= \yii\helpers\Html::button(
                    'Добавить',
                    [
                        'class' => 'btn btn-sm blue-gradient ml-0',
                        'onclick' => 'addPosition(this)',
                        'data-description' => 'descr',
                    ]
                ); ?>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</div>
