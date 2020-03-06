<?php

/**
 * @var $this \yii\web\View
 * @var $catalogs
 */

use yii\helpers\Html;
$heads = [
    'sem'=>'Семестр',
    'Index_d'=>'Код дисциплины',
    'Nazv1'=>'Наименование дисциплины',
    'shfak'=>'Факультет',
    'shkaf'=>'Кафедра',
    'kurs'=>'Курс',
    'stud'=>'Кол.студентов',
    'npot'=>'Потоков',
    'k_gr'=>'Групп',
    'P_gr'=>'Подгрупп',
    'N_group1'=>'Индекс группы',
    'Potok'=>'Поток с',
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
    'Prim'=>'Примечание',
];
$this->title = 'Общекафедральная нагрузка';
?>
<h1>Общекафедральная нагрузка</h1>

<div class="row">
    <table id="commonLoad" class="table table-striped table-bordered table-sm">
        <thead>
        <tr>
            <?php
            foreach ($heads as $value) {
                ?>
                <th class="th-sm"><?= $value ?></th>
                <?php
            }
            ?>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($data as $item) {
        ?>
            <tr>
                <?php
                foreach ($heads as $key => $value) {
                ?>
                <td><?= $item[strtoupper($key)] ?></td>
                <?php
                }
                ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>