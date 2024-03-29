<?php

/**
 * @var $this \yii\web\View
 */

$this->params['wide'] = true;

$hoursHeads = [
    'LEK_FACT'=>'Лекции',
    'LAB_FACT'=>'Лаб.раб.',
    'SEM_FACT'=>'Семинары',
    'NORMA'=>'КП,КР,РГР',
    'IND_FACT'=>'Индив.раб.',
    'PRACT_FACT'=>'Практики',
    'KONS'=>'Консульт.',
    'KZR'=>'К.р. реценз.',
    'KZS'=>'К.р. собесед.',
    'EKZ_FACT'=>'Экзамен',
    'ZACH_FACT'=>'Зачет',
    'DIPL_FACT'=>'Дипл.проект',
    'GOS_EKZ_FACT'=>'Гос.экзамен',
    'PROCH'=>'Прочее',
    'WSEGO1'=>'Всего',
    'K1'=>'Руководство КП',
    'K2'=>'Защита КП',
    'K3'=>'Руководство КР',
    'K4'=>'Защита КР',
    'K5'=>'РГР',
];

$heads = [
    'SEM'=>'Семестр',
    'SHFAK'=>'Факультет',
    'KURS'=>'Курс',
    //'INDEX_D'=>'Код дисциплины',
    'STUD'=>'Кол. студентов',
    'N_GROUP1'=>'Индекс группы',
    'POTOK'=>'Поток с',
    'HOURS'=>'Часы',
    'TYPE'=>'Тип',
    'NAZV1'=>'Наименование дисциплины',
    'FIO'=>'Преподаватель',

];
$this->title = 'Распределение нагрузки';
//$selectUsers = \yii\helpers\ArrayHelper::map($users,'id','fio');
$selectUsers = [];
foreach ($users as $item) {
    $selectUsers[$item['id'].'_'.$item['positionId']] = $item['fio'].' '.$item['position'];
}
//$positions = \yii\helpers\ArrayHelper::map($users, 'position','fio', 'id');
//print_r($positions);
?>
<h1>Распределение нагрузки для преподавателей кафедры <?=$filterForm->department?></h1>
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
        <?= $this->render('_filter-form',[
            'filterForm' => $filterForm,
            'users' => $users,
            'action' => $action,
            'method' => 'post',
            'fields' => [
                'currentYear' => '1',
                'semester' => '1',
                'emptyUser' => '1',
                'teacher' => '1'
            ],
        ]); ?>
    </div>
</div>
<!-- / Collapsible element -->

<div class="row">
    <div class="col-md-10 col-12">
        <?php if ($newData) {?>
            <div class="alert alert-danger" role="alert">
                Изменилась нагрузка кафедры. Есть нераспределенные часы
            </div>
        <?php } ?>
        <table id="departmentLoad" class="table table-striped table-bordered table-sm">
            <thead>
            <tr>
                <?php
                foreach ($heads as $key => $value) {
                    echo '<th class="th-sm"'.($key == 'NAZV1' ? 'style="width:16%"' : '').'><div>'.$value .'</div></th>';
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($data)) {
                foreach ($data as $itemKey => $item) {
                    $newLine = array_key_exists('NEW_LINE', $item);
                    echo '<tr'.($newLine ? ' class="text-danger"' : '').'>';
                    foreach ($heads as $upKey => $value) {
                        if (empty($item[$upKey])) {
                            echo '<td>';
                            if ($upKey == 'FIO') {
                                echo \yii\helpers\Html::dropDownList(
                                    'teacher_select_'.$itemKey,
                                    (($item['POSITION_ID'] ?? null) && $item['USER_ID'])
                                        ? $item['USER_ID'].'_'.$item['POSITION_ID']
                                        : null,
                                    $selectUsers,
                                    [
                                        'id' => 'teacher_select_'.$itemKey,
                                        'prompt' => 'Не назначено',
                                        'data-load_id' => $item['LOAD_ID'],
                                        'data-elem_id' => $itemKey,
                                        //'data-position' => $item['POSITION_ID'],
                                        'onchange' => 'calcHours(this)',
                                    ]
                                );
                            }
                            echo '</td>';
                            continue;
                        }
                        echo '<td'.(is_numeric($item[$upKey] ?? '') ? ' class="text-center"' : '') .'>';
                        if (is_numeric($item[$upKey])) {
                            $flt = floatval($item[$upKey]);
                            echo  $flt == 0 ? '' : $flt;
                        } else {
                            echo $item[$upKey];
                        }
                        echo '</td>';
                    }
                    echo '</tr>';
                    ?>
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
                        <th class="th-sm m-0 p-0"><?= $hoursHeads[strtoupper($key)] ?></th>
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
    <div class="col-md-2 col-12">
        <?php if (!empty($users)) { ?>
            <table id="users" class="table table-striped table-bordered table-sm">
                <thead>
                <tr>
                    <th class="th-sm">Ф.И.О</th>
                    <th class="th-sm">часы</th>
                    <th class="th-sm">ставка</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($users as $user) {
                    ?>
                    <tr>
                        <?php
                        echo '<td>'.$user['fio'].'<div class="text-small">'.$user['position'].'</div></td>';
                        echo '<td id="teacher_hours_'.$user['id'].'_'.$user['positionId'].'">'.($usersHours[$user['id'].'_'.$user['positionId']] ?? '').'</td>';
                        echo '<td>'.$user['rate'].'</td>';
                        ?>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>