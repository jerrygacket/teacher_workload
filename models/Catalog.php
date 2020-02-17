<?php

namespace app\models;

use app\models\base\BaseCatalog;
use Yii;

/**
 * This is the model class for table "catalog".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $tableName
 */
class Catalog extends BaseCatalog
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
            [['name', 'tableName'], 'string', 'max' => 256],
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
        ];
    }
}
