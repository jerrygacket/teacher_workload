<?php


namespace app\models;


use app\models\FilterForm;
use yii\base\Model;

class Load extends Model
{
    public $table = 'NAGR2016';

    /**
     * @param $filters FilterForm
     */
    public function getCommonLoad($filters = null) {
        $sql = 'select * from '.$this->table.' where CUR_YEAR='.(empty($filters->currentYear) ? date('Y') : $filters->currentYear);
        if (!empty($filters->institute)) {
            $sql .= ' and SHFAK=\''.$filters->institute.'\'';
        }
        if (!empty($filters->department)) {
            $sql .= ' and SHKAF=\''.$filters->department.'\'';
        }
        $data = \Yii::$app->fbDb
            ->createCommand(mb_convert_encoding($sql, 'CP1251', 'UTF-8'))
            ->queryAll();
        $data = mb_check_encoding($data, 'UTF-8') ? $data : mb_convert_encoding($data, 'UTF-8', 'CP1251');
        $data = array_map(function ($value) {
            $groups = explode(',', $value['POTOK']);
            $value['POTOK'] = (!empty($groups[0]) ? $groups[0].' - лек<br>':'').(!empty($groups[1]) ? $groups[1].' - сем<br>':'').(!empty($groups[2]) ? $groups[2].' - лаб.инд<br>':'');

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
}