<?php

/**
 * @var $this \yii\web\View
 * @var $filterForm \app\models\FilterForm
 */

$this->params['wide'] = true;

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
<?php
$form = \yii\widgets\ActiveForm::begin([
    'id' => 'login-form',
    'options' => [
        'class' => 'form-horizontal',
        'action'=>'/load/kaf-load',
        'method' => 'post',
        'enctype' => 'multipart/form-data'
    ],
]);
echo '<div class="row">';

echo '<div class="col-md-3 col-12">';
echo $form->field($filterForm,'currentYear')->dropDownList(
    array_combine(['2018','2019','2020'],['2018','2019','2020']),
    [
        'prompt' => 'Текущий год',
    ]
)->label(false);
echo '</div>';

echo '<div class="col-md-3 col-12">';
echo $form->field($filterForm,'institute')->dropDownList(
    \yii\helpers\ArrayHelper::map($institutes, 'SHFAK', 'NFAK'),
    ['prompt' => 'Факультет...']
)->label(false);
echo '</div>';

echo '<div class="col-md-3 col-12">';
echo $form->field($filterForm,'department')->dropDownList(
    \yii\helpers\ArrayHelper::map($departments, 'SHKAF', 'NKAF'),
    ['prompt' => 'Кафедра...']
)->label(false);
echo '</div>';
echo '<div class="col-md-3 col-12">';
echo Html::submitButton('Применить', ['class' => 'btn btn-primary']);
echo '</div>';

echo '</div>';
\yii\widgets\ActiveForm::end();
?>
<div class="row">
    <table id="commonLoad" class="table table-striped table-bordered table-sm">
        <thead>
        <tr>
            <?php
            foreach ($heads as $value) {
                ?>
                <th class="th-sm rotate"><div><?= $value ?></div></th>
                <?php
            }
            ?>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($data)) {
            foreach ($data as $item) {
                ?>
                <tr>
                    <?php
                    foreach ($heads as $key => $value) {
                        echo '<td>'.$item[strtoupper($key)].'</td>';
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
            <th class="th-sm">Период</th>
            <?php
            foreach ($totals['Год'] as $key => $value) {
                ?>
                <th class="th-sm"><?= $heads[$key] ?></th>
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