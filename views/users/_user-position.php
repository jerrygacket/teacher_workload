<?php
use yii\helpers\Html;
?>
    <li class="list-group-item pt-0 pb-0" id="posItem<?= $key ?>">
        <?php
        echo 'Должность: '. $position;
        echo ', Ставка: '. $occupation;
        echo $rate ? ', Размер ставки: '. $rate : '';

        if (isset($form) && $form) {
            echo Html::hiddenInput('posId[]', $params['posId']);
            echo Html::hiddenInput('occId[]', $params['occId']);
            echo Html::hiddenInput('rateId[]', $params['rateId']);
            echo Html::button(
                '<i class="fas fa-times"></i>',
                [
                    'class' => 'btn btn-link m-0 red-text p-1',
                    'id' => 'delBtn'.$key,
                    'title' => 'Удалить',
                    'onclick' => 'delPosition(posItem'.$key.')',
                ]
            );
        }
        ?>
    </li>