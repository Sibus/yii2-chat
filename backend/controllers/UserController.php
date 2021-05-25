<?php

namespace backend\controllers;

use backend\forms\UserForm;
use backend\models\UserFinder;
use backend\service\manage\UserManageService;
use common\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    public function __construct($id, $module, private UserManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new UserFinder();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdate($id)
    {
        $user = $this->findModel($id);
        $form = new UserForm($user);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($user->id, $form);
                return $this->redirect(['view', 'id' => $user->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'user' => $user,
        ]);
    }

    public function actionDelete($id)
    {
        $this->service->remove($id);

        return $this->redirect(['index']);
    }

    /**
     * @throws NotFoundHttpException
     */
    protected function findModel($id): ?User
    {
        if (!$model = User::findOne($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }
}
