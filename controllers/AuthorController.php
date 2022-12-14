<?php

namespace app\controllers;

use app\models\Author;
use app\models\AuthorSearch;
use app\models\Book;
use app\models\BookAuthors;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuthorController implements the CRUD actions for Author model.
 */
class AuthorController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'delete' => ['POST'],
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['index', 'create', 'update', 'delete', 'view'],
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'actions' => ['view'],
                ],
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'actions' => ['index'],
                    'matchCallback' => function ($rule, $action) {
                        if (Yii::$app->user->getIdentity()->role == User::USER_ROLE)
                            return false;

                        return true;
                    }
                ],
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'actions' => ['create', 'update', 'delete'],
                    'matchCallback' => function ($rule, $action) {
                        if (Yii::$app->user->getIdentity()->role == User::CUSTOMER_ROLE ||
                            Yii::$app->user->getIdentity()->role == User::USER_ROLE)
                                return false;

                        return true;
                    }
                ]

            ],

        ];

        return $behaviors;
    }

    /**
     * Lists all Author models.
     *
     * @return string
     */
    public function actionIndex()
    {

        $searchModel = new AuthorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Author model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);

    }

    /**
     * Creates a new Author model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    //Create author
    public function actionCreate()
    {

        $model = new Author();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    //Author update
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //Author update
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Author model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    //Author delete
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['/']);
    }

    /**
     * Finds the Author model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Author the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Author::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
