<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "userPositions".
 *
 * @property int $id
 * @property int|null $userId
 * @property int|null $positionId
 * @property int|null $rateId
 * @property int|null $occupationId
 */
class UserPositions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userPositions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'positionId', 'rateId', 'occupationId'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'userId' => Yii::t('app', 'User ID'),
            'positionId' => Yii::t('app', 'Position ID'),
            'rateId' => Yii::t('app', 'Rate ID'),
            'occupationId' => Yii::t('app', 'Occupation ID'),
        ];
    }

    public function addPosition($params) {
        $positionId = $params['positionId'] ?? null;
        $rateId = $params['rateId'] ?? null;
        $occupationId = $params['occupationId'] ?? null;
        $tableName = 'userPositions';
        if ($positionId && $rateId && $occupationId && \Yii::$app->db->schema->getTableSchema($tableName)) {
            return \Yii::$app->db->createCommand()->insert($tableName, [
                'userId' => $this->id,
                'positionId' => $positionId,
                'rateId' => $rateId,
                'occupationId' => $occupationId,
            ])->execute();
        }

        return false;
    }
}
