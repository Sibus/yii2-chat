<?php

namespace frontend\services;

use backend\repositories\UserRepository;
use common\models\Message;
use common\models\MessageForm;
use frontend\repositories\MessageRepository;

class MessageService
{
    public function __construct(private UserRepository $users, private MessageRepository $messages)
    {
    }

    public function send(int $id, MessageForm $form): void
    {
        $user = $this->users->get($id);
        $message = Message::create($user->id, $form->content);
        $this->messages->save($message);
    }

    public function hide(int $id): void
    {
        $message = $this->messages->get($id);
        $message->hide();
        $this->messages->save($message);
    }

    public function show(int $id): void
    {
        $message = $this->messages->get($id);
        $message->show();
        $this->messages->save($message);
    }
}
