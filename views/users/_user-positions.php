<?php
use yii\helpers\Html;
foreach ($userPositions as $key => $item) {
    echo $this->render('_user-position',[
        'params' => [
            'posId' => $item->positionId ?? null,
            'occId' => $item->occupationId ?? null,
            'rateId' => $item->rateId ?? null,
        ],
        'position' => $allPositions[$item->positionId] ?? 'Без должности',
        'occupation' => $allOccupations[$item->occupationId] ?? 'Нет',
        'rate' => $allRates[$item->rateId] ?? null,
        'key' => $key,
        'form' => (isset($form) && $form)]);
}