<?php

use backend\helpers\UserHelper;
use common\models\User;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserFinder */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'filter' => UserHelper::statusList(),
                'value' => function (User $user) {
                    return UserHelper::statusLabel($user->status);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'created_at',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_from',
                    'attribute2' => 'created_to',
                    'type' => DatePicker::TYPE_RANGE,
                    'separator' => '-',
                    'pluginOptions' => [
                        'todayHighlight' => true,
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ]),
                'format' => 'datetime',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
