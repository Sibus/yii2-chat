<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id [int(11)]
 * @property int $author_id [int(11)]
 * @property string $content
 * @property int $created_at [int(11)]
 * @property int|null $hidden_at [int(11)]
 *
 * @property-read User $author
 */
class Message extends ActiveRecord
{
    public static function create(int $authorId, string $content): static
    {
        $message = new static();
        $message->author_id = $authorId;
        $message->content = $content;
        $message->created_at = time();

        return $message;
    }

    public function hide(): void
    {
        $this->hidden_at = time();
    }

    public function show(): void
    {
        $this->hidden_at = null;
    }

    public function isHidden(): bool
    {
        return $this->hidden_at !== null;
    }

    public static function tableName(): string
    {
        return '{{%messages}}';
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    public function of(int $userId): bool
    {
        return $this->author_id === $userId;
    }
}
