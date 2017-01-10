<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10.01.2017
 * Time: 4:41
 */

namespace common\behaviors;



use Yii;
use yii\base\Behavior;
use yii\web\Application;

class RolePermission extends Behavior
{
    public $roles = ['admin' => 'Администратор', 'user' => 'Пользователь'];
    public $permissions = ['changeNameAndSolution' => 'Право изменять строки таблицы', 'changeRating' => 'Право ставить оценку'];

    public function events()
    {
        return [
            Application::EVENT_AFTER_ACTION => 'createRoleAndPermission',
        ];
    }

    public function createRoleAndPermission()
    {
        foreach ($this->roles as $role => $description) {
            if (empty(Yii::$app->authManager->getRole($role))) {
                $role = Yii::$app->authManager->createRole($role);
                $role->description = $description;
                Yii::$app->authManager->add($role);
            }
        }

        foreach ($this->permissions as $right => $description) {
            if (empty(Yii::$app->authManager->getPermission($right))) {
                $right = Yii::$app->authManager->createPermission($right);
                $right->description = $description;
                Yii::$app->authManager->add($right);
            }
        }
    }
}