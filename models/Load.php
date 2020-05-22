<?php


namespace app\models;


use app\traits\FunHelper;
use yii\base\Model;
use yii\db\Query;

class Load extends Model
{
    use FunHelper; // getUuid function
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
        'DIPL_FACT'=>'Дипл.проект',
        'GOS_EKZ_FACT'=>'Гос.экзамен',
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

    public $newLine = false;

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

    public function checkData($newItem, $oldItem) {
        return array_udiff($newItem, $oldItem, array($this, 'customCompare'));
    }

    public function customCompare($newItem, $oldItem) {
        if (is_array($newItem)) $a = $newItem['date'];
        else $a = $newItem;
        if (is_array($oldItem)) $b = $oldItem['date'];
        else $b = $oldItem;
        if ($a == $b) {
            return 0;
        } elseif ($a > $b) {
            return 1;
        } else {
            return -1;
        }
    }

    /**
     * Собираем строки для формы индивидуальной нагрузки
     * если поле "P_GR">1, то размножаем каждый вид работы на количество подгрупп, в поле "Индекс группы"
     * ставим крестики "х" - признак номера подгруппы, часы по данному виду работы делим поровну на несколько подгрупп.
     * @param $commonLoad //вся нагрузка на кафедру. массив из предметов с часами занятий, инфой и  описанием.
     * @var $lessons //отдельные занятия с количеством часов по предмету (лекции, лаб, экз и т.д.)
     * @var $info //инфо по предмету занятия (группа, курс, число студентов)
     * @return array
     */
    public function updateKafLoad($commonLoad) {
        $sourceKafLoad = $this->getSourceLoads($commonLoad);

//        $query = new Query();
//        $sql = 'INSERT IGNORE INTO '
//            .KafLoad::tableName()
//            .' ('.implode(',', array_keys(current($sourceKafLoad))) .') '
//            .'VALUES (1,2) (3,4) (5,6) ON DUPLICATE KEY UPDATE '.KafLoad::tableName().'.LOAD_ID = VALUES(LOAD_ID) ;'
//        $query->createCommand()->setRawSql()
        //$query->createCommand()->(KafLoad::tableName(), array_keys(current($sourceKafLoad)), $sourceKafLoad);
        // INSERT IGNORE INTO tablename (field1, field2) VALUES (1,2) (3,4) (5,6) ON DUPLICATE KEY UPDATE tablename.field1 = VALUES(field1) ;


        /*
         * $old_sql = array(
   array( 'id'=>1, 'name'=>'a', 'price'=>10.0 ),
   array( 'id'=>2, 'name'=>'b', 'price'=>20.0 ),
   array( 'id'=>3, 'name'=>'c', 'price'=>30.0 ),
);

$new_sql = array(
   array( 'id'=>1, 'name'=>'a', 'price'=>10.0 ),
   array( 'id'=>3, 'name'=>'c', 'price'=>35.0 ),
   array( 'id'=>4, 'name'=>'d', 'price'=>15.0 ),
);



$new_records = array_udiff($new_sql, $old_sql, 'cmp_id');
$deleted_records = array_udiff($old_sql, $new_sql, 'cmp_id');
$changed_records = array_uintersect($new_sql, $old_sql, 'cmp_price' );



echo "<pre>";

echo "New records\n";
print_r($new_records);

echo "\n\nDeleted records\n";
print_r($deleted_records);

echo "\n\nChanged records\n";
print_r($changed_records);

echo "</pre>";



function cmp_id( $a, $b ){
   return $b['id']-$a['id'];
}

function cmp_price( $a, $b ){
   if( $a['id']==$b['id'] ){
      if( $a['price']!=$b['price'] ) return 0;
      return 1;
   }
   return $b['id']-$a['id'];
}
         */

        foreach ($sourceKafLoad as &$sourceItem) {
            if (empty($kafLoad = KafLoad::find()->where(['LOAD_ID' => $sourceItem['LOAD_ID']])->one())) {
                $kafLoad = new KafLoad();
                $sourceItem['NEW_LINE'] = true;
                $this->newLine = true;
                $kafLoad->load($sourceItem, '');
            }
//            if (count(array_diff_assoc($kafLoad->toArray(),$sourceItem)) > 3) {
//                echo 'new line';
//                \Yii::$app->end(0);
//            }
//            echo '<pre>';
//            print_r($kafLoad->toArray());
//            print_r($sourceItem);
//            print_r(array_diff_assoc($kafLoad->toArray(),$sourceItem));
//            echo '</pre>';
//            \Yii::$app->end(0);
            if (!$kafLoad->save()) {
                echo '<pre>';
                print_r($kafLoad->errors);
                echo '</pre>';
            }
        }

        return $sourceKafLoad;
    }

    /**
     * @param $commonLoad
     * @return array
     * // формируем массив занятий с часами из исходной базы firebird
     */
    public function getSourceLoads($commonLoad) {
        $result = [];
        foreach ($commonLoad as $item) {
            $lessons = $this->getLessons($item);
            $info = $this->getSubjectInfo($item);

//            if (substr_count($item['NAZV1'], 'ГАК') > 0) {
//                echo '<pre>';
//                print_r($info);
//                echo '</pre>';
//                \Yii::$app->end(0);
//            }
            foreach ($lessons as $key => $lesson) {
                if ($key != 'WSEGO1') {
                    $i = 0;
                    $groupIndex = $info['N_GROUP1'];
                    $splitHours = array_key_exists($key, $this->halfHours);
                    // если нет подгруп, то это слен ГАК/ГЭК или серкетарь или председатель
                    $subGroups = ($info['P_GR'] ?? 1);
                    // разбиваем по формуле: кол членов = общее число часов / (кол.студентов * 0,5)
                    if (substr_count($item['NAZV1'], 'Член Г') > 0) {
                        $subGroups = $lesson/($info['STUD'] * 0.5);
//                        echo '<pre>';
//                        print_r($subGroups);
//                        echo '</pre>';
//                        \Yii::$app->end(0);
                    }
                    while ($i < $subGroups) {
                        if (($subGroups > 1) && $splitHours) {
                            $groupIndex .= 'x';
                        }
                        $tmp = array_merge($info, [
                            //'ID' => $this->genUuid(),
                            'N_GROUP1' => $groupIndex,
                            //$key => $lesson/$info['P_GR'],
                            'HOURS' => ($splitHours) ? $lesson/$subGroups : $lesson,
                            'TYPE' => $this->hoursHeads[$key],
                        ]);
                        $tmp['LOAD_ID'] = implode('', $tmp);
                        $tmp['WSEGO1'] = $lessons['WSEGO1'];
                        $result[$tmp['LOAD_ID']] = $tmp;
                        if (!$splitHours) {
                            break;
                        }
                        $i++;
                    }
//                    if ($key == 'DIPL_FACT') {
//                        echo '<pre>';
//                        print_r($result[$tmp['LOAD_ID']]);
//                        echo '</pre>';
//                        \Yii::$app->end(0);
//                    }
                }
            }
        }

        return $result;
    }

    /**
     * @param $filterForm FilterForm
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getSavedKafLoad($filterForm) {
        // уже имеющийся массив занятий с распределенными часами
        $query = KafLoad::find();
        $query->where(['SHKAF' => $filterForm->department]);
        if ($filterForm->emptyUser == '1') {
            $query->andWhere(['USER_ID' => null]);
        }
        $query->andFilterWhere(['USER_ID' => $filterForm->teacher]);

        return $query->all();
    }

    public function getLessons($subject) {
        $result = [];
        //$val = 0;
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