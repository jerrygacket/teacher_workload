<?php
/* @var $this \yii\web\View */
/**
 * @var $userId integer
 */
$positions = \app\models\base\Position::find()->all();
$occupations = \app\models\base\Occupation::find()->all();
$rates = \app\models\base\Rate::find()->all();
$model = new \app\models\base\UserPositions();
?>
<div class="card">
    <div class="card-body">
        <ul id="positions">

        </ul>
        <div class="row">
            <div class="col-12 mb-3">
                <?= \yii\helpers\Html::dropDownList('position',null,
                    \yii\helpers\ArrayHelper::map(
                        $positions,'id','name'
                    ),
                    [
                        'id' => 'position',
                        'prompt' => 'Должность...',
                    ]
                )?>
            </div>
            <div class="col-12 mb-3">
                <?=  \yii\helpers\Html::dropDownList('occupation',null,
                    \yii\helpers\ArrayHelper::map(
                        $occupations,'id','name'
                    ),
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
                    \yii\helpers\ArrayHelper::map(
                        $rates,'id','name'
                    ),
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
    </div>
</div>
