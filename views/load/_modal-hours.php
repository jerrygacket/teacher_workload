<?php
/**
 * @var $item
 * @var $hoursHeads
 * @var $modalId
 */
?>
<!-- Modal -->
<div class="modal fade" id="<?= $modalId ?>" tabindex="-1" role="dialog" aria-labelledby="Label<?= $modalId ?>"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Label<?= $modalId ?>">Часы нагрузки по предмету <br><?=$item['NAZV1']?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <p>Институт: <?=$item['SHFAK']?></p>
                        <p>Факультет: <?=$item['SHKAF']?></p>
                        <p>Семестр: <?=$item['SEM']?></p>
                        <p>Курс: <?=$item['KURS']?></p>
                        <p>Группа: <?=$item['N_GROUP1']?></p>
                    </div>
                    <div class="col-6"><?php
                        foreach ($hoursHeads as $key => $value) {
                            $flt = floatval($item[strtoupper($key)]);
                            if ($flt != 0) {
                                echo '<p>';
                                echo  $value.': '.$flt;
                                echo '</p>';
                            }
                        }
                        ?></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
<!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>
