<?php

namespace frontend\controllers;

use common\models\Message;
use common\models\MessageForm;
use frontend\services\MessageService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class ChatController extends Controller
{
    public function __construct($id, $module, private MessageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['seeMessage'],
                    ],
                    [
                        'actions' => ['show', 'hide'],
                        'allow' => true,
                        'roles' => ['markMessage'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $form = new MessageForm();

        if (
            $form->load(Yii::$app->request->post())
            && $form->validate()
            && Yii::$app->user->can('sendMessage')
        ) {
            try {
                $this->service->send(Yii::$app->user->id, $form);
                $this->refresh();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        $messages = Message::find()->orderBy(['created_at' => SORT_DESC])->all();

        return $this->render('index', [
            'model' => $form,
            'messages' => $messages,
        ]);
    }

    public function actionHide(int $id)
    {
        try {
            $this->service->hide($id);
            return $this->redirect(['chat/index']);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    public function actionShow(int $id)
    {
        try {
            $this->service->show($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['chat/index']);
    }
}
