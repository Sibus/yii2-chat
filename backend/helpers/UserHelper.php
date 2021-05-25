<?php

namespace backend\helpers;

use common\models\User;
use yii\helpers\Html;

class UserHelper
{
    public static function statusList(): array
    {
        return [
            User::STATUS_ACTIVE => 'Active',
            User::STATUS_INACTIVE => 'Inactive',
            User::STATUS_DELETED => 'Deleted',
        ];
    }

    public static function statusName(int $status): string
    {
        return static::statusList()[$status] ?? Html::encode($status);
    }

    public static function statusLabel(int $status): string
    {
        $class = match ($status) {
            User::STATUS_ACTIVE => 'label label-success',
            User::STATUS_DELETED => 'label label-danger',
            default => 'label label-default',
        };

        return Html::tag('span', static::statusName($status), [
            'class' => $class,
        ]);
    }
}
