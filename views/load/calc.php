<?php

/**
 * @var $this \yii\web\View
 */

$this->params['wide'] = true;

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
$this->title = 'Общекафедральная нагрузка';
?>
<h1>Распределение нагрузки для преподавателей кафедры <?=$filterForm->department?></h1>
<?= $this->render('_filter-form',[
    'filterForm' => $filterForm,
    'action' => $action,
    'fields' => [
        'currentYear' => '1',
        'semester' => '1'
    ],
]); ?>
<div class="row">
    <div class="col-12">
        <table id="commonLoad" class="table table-striped table-bordered table-sm">
            <thead>
            <tr>
                <?php
                foreach ($heads as $key => $value) {
                    echo '<th class="th-sm"><div>'.$value .'</div></th>';
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($data)) {
                foreach ($data as $itemKey => $item) {
                    foreach ($heads as $key => $value) {
                            echo '<tr>';
                            $upKey = strtoupper($key);
                            echo '<td'.(is_numeric($item[$upKey]) ? ' class="text-center"' : '') .'>';
                            if (is_numeric($item[$upKey])) {
                                $flt = floatval($item[$upKey]);
                                echo  $flt == 0 ? '' : $flt;
                            } elseif ($key == 'Nazv1') {
                                echo \yii\helpers\Html::button($item[$upKey], [
                                    'class'=>'btn btn-link',
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
                <?php }
            }?>
            </tbody>
        </table>
        <?php if (!empty($totals)) { ?>
            <table id="totals" class="table table-striped table-bordered table-sm">
                <thead>
                <tr>
                    <th class="th-sm">Период</th>
                    <?php
                    foreach ($totals['Год'] as $key => $value) {
                        ?>
                        <th class="th-sm"><?= $hoursHeads[$key] ?></th>
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
                        echo '<td>'.$period.'</td>';
                        foreach ($item as $value) {
                            echo '<td>'.round($value*100)/100..'</td>';
                        }
                        ?>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>
<pre>
    <?php print_r($data); ?>
</pre>