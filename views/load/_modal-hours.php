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
                <h5 class="modal-title" id="Label<?= $modalId ?>">Часы нагрузки</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                foreach ($hoursHeads as $key => $value) {
                    $flt = floatval($item[strtoupper($key)]);
                    if ($flt != 0) {
                        echo '<p>';
                        echo  $value.': '.$flt;
                        echo '</p>';
                    }
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
<!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>
