<?php

use yii\db\Migration;

class m210521_150421_init_rbac extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        $seeMessage = $auth->createPermission('seeMessage');
        $seeMessage->description = 'See a message';
        $auth->add($seeMessage);

        $sendMessage = $auth->createPermission('sendMessage');
        $sendMessage->description = 'Send a message';
        $auth->add($sendMessage);

        $markMessage = $auth->createPermission('markMessage');
        $markMessage->description = 'Mark/unmark a message as incorrect';
        $auth->add($markMessage);

        $manageRole = $auth->createPermission('manageRole');
        $manageRole->description = 'Manage roles';
        $auth->add($manageRole);

        $guest = $auth->createRole('guest');
        $auth->add($guest);
        $auth->addChild($guest, $seeMessage);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $sendMessage);
        $auth->addChild($user, $guest);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $markMessage);
        $auth->addChild($admin, $manageRole);
        $auth->addChild($admin, $user);
    }

    public function down()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}
