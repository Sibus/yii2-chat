<?php

namespace backend\repositories;

use common\models\User;

class UserRepository
{
    public function get(int $id): User
    {
        if (!$user = User::findOne($id)) {
            throw new \DomainException('User is not found.');
        }

        return $user;
    }

    public function remove(User $user)
    {
        if (!$user->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
