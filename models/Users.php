<?php

namespace app\models;

use app\models\base\BaseUsers;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Users extends BaseUsers
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
}
