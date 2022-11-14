<?php

namespace app\controllers;

use app\models\Author;
use app\models\AuthorSearch;
use app\models\Book;
use app\models\BookAuthors;
use app\models\BookSearch;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'create', 'update', 'delete', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'delete', 'view'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    /**
     * Lists all Book models.
     *
     * @return string
     */

    public function actionIndex()
    {
        $searchModel = [];
        $dataProvider = [];

        switch (Yii::$app->user->getIdentity()->role) {
            case User::ADMIN_ROLE:
                $searchModel = new BookSearch();
                $dataProvider = $searchModel->search($this->request->queryParams);
                break;
            case User::USER_ROLE:
                $searchModel = new BookSearch();
                $dataProvider = $searchModel->searchByAuthorId($this->request->queryParams, Yii::$app->user->getIdentity()->author_id);
                break;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->getIdentity()->getId() == $id)
            $this->redirect('/book');

        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    //Create Book
    public function actionCreate()
    {
        $model = new Book();

        if (Yii::$app->user->getIdentity()->role == User::USER_ROLE)
            $model->authorsArr = [Yii::$app->user->getIdentity()->author_id];

        if ($model->load($this->request->post()) && $model->save()) {
            foreach ($model->authorsArr as $authorId) {
                $book_author = new BookAuthors();
                $book_author->book_id = $model->id;
                $book_author->author_id = $authorId;
                $book_author->save();
            }
            return $this->redirect('/book');
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    //Book update
    public function actionUpdate($id)
    {
        //Books Update
        $model = $this->findModel($id);

        if (Yii::$app->user->getIdentity()->role == User::USER_ROLE && $model->load($this->request->post())) {
            $existAuthorIdArr = [];

            $cond = false;
            foreach ($model->authors as $author) {
                array_push($existAuthorIdArr, $author->id);
                if($author->id == Yii::$app->user->getIdentity()->getId())
                {
                    $cond = true;
                }
            }

            if(!$cond)
            {
                $this->redirect('/book');
            }

            $model->authorsArr = $existAuthorIdArr;
            $model->save();

            $this->redirect('/book');
        }


        if ($model->load($this->request->post()) && $model->save()) {

            $newAuthorIdArr = $model->authorsArr;
            $existAuthorIdArr = [];

            foreach ($model->authors as $author) {
                array_push($existAuthorIdArr, $author->id);
            }

            foreach ($newAuthorIdArr as $newBookId) {
                $cond = true;
                foreach ($existAuthorIdArr as $key => $existBookId) {
                    if ($newBookId == $existBookId) {
                        $cond = false;
                        unset($existAuthorIdArr[$key]);
                        break;
                    }
                }

                if ($cond) {
                    $book_author = new BookAuthors();
                    $book_author->book_id = $model->id;
                    $book_author->author_id = $newBookId;
                    $book_author->save();
                }

            }

            BookAuthors::deleteAll(['book_id' => $id, 'author_id' => $existAuthorIdArr]);

            return $this->redirect('/book');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    //Book delete
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['/book']);
    }


    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
