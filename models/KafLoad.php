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

    public function setUserId($userId) {
        $this->USER_ID = $userId;
    }

    public function setPositionID($positionId) {
        $this->POSITION_ID = $positionId;
    }

    public function getUserHours($userId = null) {
        if (!$this->USER_ID && !$userId) {
            return false;
        }

        $result = 0;
        foreach ($this::findAll(['USER_ID' => $userId ?? $this->USER_ID]) as $item) {
            $result += $item->HOURS;
        }

        return $result;
    }

    public static function getAllUsersHours($userIds) {
        $result = [];
        foreach (self::find()->where(['USER_ID' => $userIds])->asArray()->all() as $item) {
            $key = $item['USER_ID'].'_'.$item['POSITION_ID'];
            $result[$key] = ($result[$key] ?? 0) + $item['HOURS'];
        }

        return $result;
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