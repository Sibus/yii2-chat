<?php

namespace frontend\repositories;

use common\models\Message;

class MessageRepository
{
    public function save(Message $message): void
    {
        if (!$message->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function get(int $id): Message
    {
        if (!$message = Message::findOne($id)) {
            throw new \DomainException('Message is not found.');
        }

        return $message;
    }
}
