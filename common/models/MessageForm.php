<?php

namespace common\models;

use yii\base\Model;
use yii\db\ActiveQuery;

/**
 * @property int $id [int(11)]
 * @property int $author_id [int(11)]
 * @property string $content
 * @property int $created_at [int(11)]
 * @property int|null $hidden_at [int(11)]
 *
 * @property-read User $author
 */
class MessageForm extends Model
{
    public string $content = '';

    public function rules(): array
    {
        return [
            ['content', 'required'],
            ['content', 'string'],
        ];
    }
}
