<?php

/**
 * @var $this \yii\web\View
 *  * @var $filterForm \app\models\FilterForm
 */
$this->title = 'Общекафедральная нагрузка';
$this->params['wide'] = true;
$this->params['h1'] = $this->title;

$hoursHeads = [
    'Lek_fact'=>'Лекции',
    'Lab_fact'=>'Лаб.раб.',
    'Sem_fact'=>'Семинары',
    'Norma'=>'КП,КР,РГР',
    'Ind_fact'=>'Индив.раб.',
    'Pract_fact'=>'Практики',
    'kons'=>'Консульт.',
    'KZR'=>'К.р. реценз.',
    'KZS'=>'К.р. собесед.',
    'Ekz_fact'=>'Экзамен',
    'Zach_fact'=>'Зачет',
    'Dipl_fact'=>'Дипл.проект',
    'Gos_Ekz_fact'=>'Гос.экзамен',
    'Proch'=>'Прочее',
    'Wsego1'=>'Всего',
];

$heads = [
    'sem'=>'Семестр',
    'Index_d'=>'Код дисциплины',
    'Nazv1'=>'Наименование дисциплины',
    'shfak'=>'Факультет',
    'shkaf'=>'Кафедра',
    'kurs'=>'Курс',
    'stud'=>'Кол. студентов',
    'npot'=>'Потоков',
    'k_gr'=>'Групп',
    'P_gr'=>'Подгрупп',
    'N_group1'=>'Индекс группы',
    'Potok'=>'Поток с',
    'Wsego1'=>'Всего',
    'Prim'=>'Примечание',
];

?>
<!--<h1 style="font-size: 16px">Общекафедральная нагрузка</h1>-->

<!-- Collapse buttons -->
<div>
    <a class="btn btn-outline-primary btn-sm" data-toggle="collapse" href="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
        Фильтры
    </a>
</div>
<!-- / Collapse buttons -->

<!-- Collapsible element -->
<div class="collapse" id="collapseFilter">
    <div class="mt-3">
        <?= $this->render('_filter-form',['filterForm' => $filterForm, 'action' => $action,]); ?>
    </div>
</div>
<!-- / Collapsible element -->

<div class="row">
    <div class="col-12">
        <table id="commonLoad" class="table table-striped table-bordered table-sm">
            <thead>
            <tr>
                <?php
                //$verticals = ['kurs', 'stud', 'sem'];
                foreach ($heads as $key => $value) {
                    echo '<th class="th-sm m-0">'.$value .'</th>';
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($data)) {
                foreach ($data as $itemKey => $item) {
                    ?>
                    <tr>
                        <?php
                        foreach ($heads as $key => $value) {
                            $upKey = strtoupper($key);
                            echo '<td class="m-0 p-0'.(is_numeric($item[$upKey]) ? ' text-center' : '') .'">';
                            if (is_numeric($item[$upKey])) {
                                $flt = floatval($item[$upKey]);
                                echo  $flt == 0 ? '' : $flt;
                            } elseif ($key == 'Nazv1') {
                                echo \yii\helpers\Html::button($item[$upKey], [
                                    'class'=>'btn btn-link m-0 p-0 text-left',
                                    'data-toggle'=>'modal',
                                    'data-target'=>'#Modal'.$itemKey,
                                ]);
                                echo $this->render('_modal-hours',['item' => $item, 'hoursHeads' => $hoursHeads, 'modalId' => 'Modal'.$itemKey]);
                            } else {
                                echo $item[$upKey];
                            }
                            echo '</td>';
                        }
                        ?>
                    </tr>
                <?php }
            }?>
            </tbody>
        </table>
        <?php if (!empty($totals)) { ?>
            <table id="totals" class="table table-striped table-bordered table-sm">
                <thead>
                <tr>
                    <th class="th-sm m-0 p-0">Период</th>
                    <?php
                    foreach ($totals['Год'] as $key => $value) {
                        ?>
                        <th class="th-sm m-0 p-0"><?= $hoursHeads[$key] ?></th>
                        <?php
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($totals as $period => $item) {
                    ?>
                    <tr>
                        <?php
                        echo '<td class="m-0 p-0">'.$period.'</td>';
                        foreach ($item as $value) {
                            echo '<td class="m-0 p-0">'.round($value*100)/100..'</td>';
                        }
                        ?>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>