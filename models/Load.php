<?php


namespace app\models;


use yii\base\Model;

class Load extends Model
{
    public $table = 'NAGR2016';
    public $currentYear = '2019';
    public $hoursHeads = [
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

    public function getKafLoad($commonLoad){
        $result = [];
        foreach ($commonLoad as $item) {
            $lessons = $this->getLessons($item);
            $info = $this->getSubjectInfo($item);
            foreach ($lessons as $key => $lesson) {
                $result[] = array_merge($info, [$key => $lesson]);
            }
            echo '<pre>';
            print_r($result);
            echo '</pre>';
            \Yii::$app->end(0);
        }

        return [];
    }

    public function getLessons($subject) {
        $result = [];
        foreach ($this->hoursHeads as $key => $value) {
            $upKey = strtoupper($key);
            if (is_numeric($subject[$upKey]) && ($val = floatval($subject[$upKey]))) {
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