<?php


namespace app\models;


use app\traits\FunHelper;
use yii\base\Model;

class Load extends Model
{
    use FunHelper;
    public $table = 'NAGR2016';
    public $currentYear = '2019';
    public $hoursHeads = [
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
    /**
     * Типы занятий, часы которых необходимо делить по подгруппам
     * @var array
     */
    public $halfHours = [
        'LAB_FACT'=>'Лаб.раб.',
        'IND_FACT'=>'Индив.раб.',
        'KONS'=>'Консульт.',
        'ZACH_FACT'=>'Зачет',
        'K1'=>'Руководство КП',
        'K2'=>'Защита КП',
        'K3'=>'Руководство КР',
        'K4'=>'Защита КР',
        'K5'=>'РГР',
        'NORMA'=>'КП,КР,РГР',
    ];
    public $heads = [
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

    /**
     * @param $filters FilterForm
     * @return array|bool|false|string|string[]|null
     * @var $currentUser \app\models\Users
     */
    public function getCommonLoad($filters = null) {
//        if (\Yii::$app->user->identity->username != 'admin') {
//            $userModel = new Users();
//            $filters->department = $userModel::findOne(['id' => \Yii::$app->user->id])->getDepartment()->one()['SHKAF'];
//            //print_r($filters);
//        }
        $sql = 'select * from '.$this->table.' where CUR_YEAR='.(empty($filters->currentYear) ? $this->currentYear : $filters->currentYear);
        if (!empty($filters->institute)) {
            $sql .= ' and SHFAK=\''.$filters->institute.'\'';
        }
        if (!empty($filters->department)) {
            $sql .= ' and SHKAF=\''.$filters->department.'\'';
        }
        if (!empty($filters->semester)) {
            $sql .= ' and SEM=\''.$filters->semester.'\'';
        }
        $data = \Yii::$app->fbDb
            ->createCommand(mb_convert_encoding($sql, 'CP1251', 'UTF-8'))
            ->queryAll();
        $data = mb_check_encoding($data, 'UTF-8') ? $data : mb_convert_encoding($data, 'UTF-8', 'CP1251');
        $data = array_map(function ($value) {
            $groups = explode(',', $value['POTOK']);
            $value['POTOK'] = (!empty($groups[0]) ? $groups[0].'-лек':'').PHP_EOL.(!empty($groups[1]) ? $groups[1].'-сем':'').PHP_EOL.(!empty($groups[2]) ? $groups[2].'-лаб.инд':'');
            $value['POTOK'] = str_replace(PHP_EOL, '<br>', trim($value['POTOK']));

            return $value;
        }, $data);

        return $data;
    }

    public function getTotals($data, $semestr = null) {
        $result = [
            'Lek_fact' => 0,
            'Lab_fact' => 0,
            'Sem_fact' => 0,
            'Norma' => 0,
            'Ind_fact' => 0,
            'Pract_fact' => 0,
            'kons'=> 0,
            'KZR'=> 0,
            'KZS'=> 0,
            'Ekz_fact'=> 0,
            'Zach_fact'=> 0,
            'Dipl_fact'=> 0,
            'Gos_Ekz_fact'=> 0,
            'Proch'=> 0,
            'Wsego1'=> 0,
        ];
        foreach ($data as $item) {
            if ($semestr and $item['SEM'] != $semestr) {
                continue;
            }
            foreach ($result as $key => &$total) {
                $total += $item[strtoupper($key)];
            }
        }

        return $result;
    }

    /**
     * Собираем строки для формы индивидуальной нагрузки
     * если поле "P_GR">1, то размножаем каждый вид работы на количество подгрупп, в поле "Индекс группы"
     * ставим крестики "х" - признак номера подгруппы, часы по данному виду работы делим поровну на несколько подгрупп.
     * @param $commonLoad
     * @return array
     */
    public function getKafLoad($commonLoad){
        $result = [];
        foreach ($commonLoad as $item) {
            $lessons = $this->getLessons($item);
            $info = $this->getSubjectInfo($item);

            foreach ($lessons as $key => $lesson) {
                if ($key != 'WSEGO1') {
                    $i = 0;
                    $groupIndex = $info['N_GROUP1'];
                    $splitHours = array_key_exists($key, $this->halfHours);
                    while ($i < $info['P_GR']) {
                        if (($info['P_GR'] > 1) && $splitHours) {
                            $groupIndex .= 'x';
                        }
                        $tmp = array_merge($info, [
                            //'ID' => $this->genUuid(),
                            'N_GROUP1' => $groupIndex,
                            //$key => $lesson/$info['P_GR'],
                            'HOURS' => ($splitHours) ? $lesson/$info['P_GR'] : $lesson,
                            'TYPE' => $this->hoursHeads[$key]
                        ]);
                        $tmp['LOAD_ID'] = implode('', $tmp);
                        if (empty(KafLoad::find()->where(['LOAD_ID' => $tmp['LOAD_ID']])->one())) {
                            $kafLoad = new KafLoad();
                            $kafLoad->load($tmp, '');
                            if (!$kafLoad->save()) {
                                echo '<pre>';
                                print_r($kafLoad->errors);
                                echo '</pre>';
                            }
                            $tmp['NEW_LINE'] =true;
                        }
                        $result[] = $tmp;//json_decode(json_encode($tmp), FALSE);
                        if (!$splitHours) {
                            break;
                        }
                        $i++;
                    }
                }

//                if (array_key_exists($key, $this->halfHours)) {
//
//                } elseif ($key != 'WSEGO1') {
//                    $tmp = array_merge($info, [
////                        'ID' => $this->genUuid(),
//                        'HOURS' => $lesson,
//                        'TYPE' => $this->hoursHeads[$key]]);
//                    $tmp['LOAD_ID'] = implode('', $tmp);
//                    $result[] = $tmp;//json_decode(json_encode($tmp), FALSE);
//                }
            }
        }

//        foreach ($result as $item) {
//            if (empty(KafLoad::find()->where([])))
//        }
//        echo '<pre>';
//        print_r($commonLoad);
//        echo '</pre>';
        \Yii::$app->end(0);

        return $result;
    }

    public function getLessons($subject) {
        $result = [];
        $val = 0;
        foreach ($this->hoursHeads as $upKey => $value) {
            if (is_numeric($subject[$upKey]) && ($val = floatval($subject[$upKey])) && $val > 0) {
                $result[$upKey] = $val;
            }
        }

        return $result;
    }

    public function getSubjectInfo($subject) {
        $result = [];
        foreach ($this->heads as $key => $value) {
            $upKey = strtoupper($key);
            $result[$upKey] = $subject[$upKey];
        }

        return $result;
    }
}