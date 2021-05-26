<?php

/* @var $this \yii\web\View */
/* @var $model \common\models\MessageForm */
/* @var $messages \common\models\Message[] */

use frontend\assets\ChatAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

ChatAsset::register($this);
?>

<div class="row">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
        <div class="panel">
            <!--Heading-->
            <div class="panel-heading">
                <h3 class="panel-title">Chat</h3>
            </div>

            <!--Widget body-->
            <div>
                <div class="nano has-scrollbar" style="height:380px">
                    <div class="nano-content" tabindex="0" style="padding: 15px; right: -17px;">
                        <ul class="list-unstyled">
                            <?php foreach ($messages as $message): ?>
                                <?php if (!$message->isHidden() || Yii::$app->user->can('markMessage')): ?>
                                    <li style="margin-bottom: 15px;">
                                        <?= $this->render('_message', [
                                            'message' => $message,
                                        ]) ?>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="nano-pane">
                        <div class="nano-slider" style="height: 141px; transform: translate(0px, 0px);"></div>
                    </div>
                </div>

                <?php if (Yii::$app->user->can('sendMessage')): ?>
                    <!--Widget footer-->
                    <div class="panel-footer">
                        <?php $form = ActiveForm::begin(); ?>

                        <div class="row">
                            <div class="col-xs-9">
                                <?= $form->field($model, 'content')->textInput([
                                    'placeholder' => 'Enter your text',
                                    'class' => 'form-control chat-input',
                                ])->label(false) ?>
                            </div>
                            <div class="col-xs-3">
                                <?= Html::submitButton('Send', ['class' => 'btn btn-primary btn-block']) ?>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
