<?php


namespace app\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class KafLoad extends \app\models\base\KafLoad
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_on', 'updated_on'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_on'],
                ],
                'value' => new Expression('NOW()')
            ]
        ];
    }

//    /**
//     * {@inheritdoc}
//     */
//    public function rules()
//    {
//        return array_merge(parent::rules(), [
//            [['SEM', 'KURS', 'STUD', 'NPOT', 'K_GR', 'P_GR', 'HOURS'], 'safe'],
//            [['WSEGO1'], 'safe'],
//            [['created_on', 'updated_on'], 'safe'],
//            [['LOAD_ID'], 'safe'],
//            [['INDEX_D', 'NAZV1', 'SHKAF'], 'safe'],
//            [['SHFAK', 'N_GROUP1', 'POTOK', 'PRIM', 'TYPE'], 'safe'],
//        ]);
//    }
}