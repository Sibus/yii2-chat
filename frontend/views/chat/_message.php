<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $message \common\models\Message */

?>
<div style="padding-left: 15px; padding-right: 15px;" class="
    <?= $message->of(Yii::$app->user->identity->getId()) ? 'speech-right' : '' ?>
">
    <div class="
        speech
        <?= $message->isHidden() ? 'speech_hidden' : '' ?>
        <?= Yii::$app->authManager->checkAccess($message->author_id, 'admin') ? 'speech_highlight' : '' ?>
    ">
        <span class="speech__heading">
            <?= $message->author->username ?>
            <?php if (Yii::$app->user->can('markMessage')): ?>
                <?php if ($message->isHidden()): ?>
                    <?= Html::a('Show', ['chat/show', 'id' => $message->id], ['class' => 'hide_show_link']) ?>
                <?php else: ?>
                    <?= Html::a('Hide', ['chat/hide', 'id' => $message->id], ['class' => 'hide_show_link']) ?>
                <?php endif; ?>
            <?php endif; ?>
        </span>
        <p><?= Html::encode($message->content) ?></p>
        <p class="speech-time">
            <i class="fa fa-clock-o fa-fw"></i>
            <?= Yii::$app->formatter->asDatetime($message->created_at) ?>
        </p>
    </div>
</div>
