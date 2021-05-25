<?php

namespace backend\service\manage;

use backend\forms\UserForm;
use backend\repositories\UserRepository;

class UserManageService
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function edit(int $id, UserForm $form)
    {
        $user = $this->repository->get($id);
        $user->setRoles($form->roles);
    }

    public function remove(int $id): void
    {
        $user = $this->repository->get($id);
        $this->repository->remove($user);
    }
}
