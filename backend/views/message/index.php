<?php

use common\models\Message;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Messages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'author',
                'value' => function (Message $message) {
                    return Html::a($message->author->username, ['user/view', 'id' => $message->author_id]);
                },
                'format' => 'raw',
            ],
            'content:ntext',

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

            [
                'attribute' => 'hidden_at',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'hidden_from',
                    'attribute2' => 'hidden_to',
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

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{show}',
                'buttons' => [
                    'show' => function ($url, $model, $key) {
                        return Html::a('Show', $url);
                    },
                ]
            ],
        ],
    ]); ?>


</div>
