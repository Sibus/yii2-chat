<?php

use backend\helpers\UserHelper;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            [
                'label' => 'Roles',
                'value' => function (User $user) {
                    $result = '<ul class="list-unstyled">';
                    foreach ($user->getRoles() as $roleName) {
                        $result .= '<li>' . Html::encode($roleName) . '</li>';
                    }

                    return $result . '</ul>';
                },
                'format' => 'raw',
            ],
            'email:email',
            [
                'attribute' => 'status',
                'value' => UserHelper::statusLabel($model->status),
                'format' => 'raw',
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
