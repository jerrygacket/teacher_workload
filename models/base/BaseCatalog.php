<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "catalog".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $tableName
 * @property string|null $modelName
 */
class BaseCatalog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'catalog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'tableName', 'modelName'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'tableName' => Yii::t('app', 'Table Name'),
            'modelName' => Yii::t('app', 'Model Name'),
        ];
    }
}
