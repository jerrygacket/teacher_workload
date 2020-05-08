<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "kafLoad".
 *
 * @property int $ID
 * @property string|null $LOAD_ID
 * @property int|null $SEM
 * @property string|null $INDEX_D
 * @property string|null $NAZV1
 * @property string|null $SHFAK
 * @property string|null $SHKAF
 * @property int|null $KURS
 * @property int|null $STUD
 * @property int|null $NPOT
 * @property int|null $K_GR
 * @property int|null $P_GR
 * @property string|null $N_GROUP1
 * @property string|null $POTOK
 * @property float|null $WSEGO1
 * @property string|null $PRIM
 * @property float|null $HOURS
 * @property string|null $TYPE
 * @property string $created_on
 * @property string $updated_on
 */
class KafLoad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kafLoad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SEM', 'KURS', 'STUD', 'NPOT', 'K_GR', 'P_GR'], 'integer'],
            [['WSEGO1', 'HOURS'], 'number'],
            [['created_on', 'updated_on'], 'safe'],
            [['LOAD_ID'], 'string', 'max' => 1024],
            [['INDEX_D', 'NAZV1', 'SHKAF'], 'string', 'max' => 256],
            [['SHFAK', 'N_GROUP1', 'POTOK', 'PRIM', 'TYPE'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'LOAD_ID' => Yii::t('app', 'Load ID'),
            'SEM' => Yii::t('app', 'Sem'),
            'INDEX_D' => Yii::t('app', 'Index D'),
            'NAZV1' => Yii::t('app', 'Nazv1'),
            'SHFAK' => Yii::t('app', 'Shfak'),
            'SHKAF' => Yii::t('app', 'Shkaf'),
            'KURS' => Yii::t('app', 'Kurs'),
            'STUD' => Yii::t('app', 'Stud'),
            'NPOT' => Yii::t('app', 'Npot'),
            'K_GR' => Yii::t('app', 'K Gr'),
            'P_GR' => Yii::t('app', 'P Gr'),
            'N_GROUP1' => Yii::t('app', 'N Group1'),
            'POTOK' => Yii::t('app', 'Potok'),
            'WSEGO1' => Yii::t('app', 'Wsego1'),
            'PRIM' => Yii::t('app', 'Prim'),
            'HOURS' => Yii::t('app', 'Hours'),
            'TYPE' => Yii::t('app', 'Type'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_on' => Yii::t('app', 'Updated On'),
        ];
    }
}
