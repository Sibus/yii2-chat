<?php

namespace backend\forms;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\rbac\Role;

/**
 * @property-read User $user
 */
class UserForm extends Model
{
    public $roles;
    private $user;

    public function __construct(User $user = null, $config = [])
    {
        parent::__construct($config);

        if ($user) {
            $roles = Yii::$app->authManager->getRolesByUser($user->id);
            $this->roles = array_map(fn (Role $role) => $role->name, array_values($roles));
            $this->user = $user;
        }
    }

    public function getRoleList(): array
    {
        $roles = Yii::$app->authManager->getRoles();

        return array_map(fn (Role $role) => $role->name, $roles);
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function rules(): array
    {
        return [
            ['roles', 'default', 'value' => []],
            ['roles', 'validateRoles'],
        ];
    }

    public function validateRoles($attribute)
    {
        $roles = Yii::$app->authManager->getRoles();
        foreach ($this->$attribute as $roleName) {
            if (!isset($roles[$roleName])) {
                $this->addError($attribute, "Role '{$roleName}' does not exist.");
            }
        }
    }
}
