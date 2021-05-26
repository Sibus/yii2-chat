<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * @see Message
 */
class MessageQuery extends ActiveQuery
{
    public function hidden(): MessageQuery
    {
        return $this->andWhere(['not', ['hidden_at' => null]]);
    }
}
