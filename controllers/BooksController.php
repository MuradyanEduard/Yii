<?php

namespace app\controllers;

use app\models\Authors;
use app\models\Books;
use app\models\BooksAuthors;
use app\models\BooksSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BooksController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],

            ]
        );
    }

    /**
     * Lists all Book models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BooksSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

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
        $model = Books::find()->select('*')->where(['books.id' => $id])->with('authors')->one();

        //Get all not related authors
        $arr = \app\models\Books::find()->with('authors')->where(['books.id' => $id])
            ->asArray()->all();
        $authorId = [];

        foreach ($arr as $row) {
            foreach ($row['authors'] as $authors) {
                array_push($authorId, $authors['id']);
            }
        }

        $modelAddAuthors = \app\models\Authors::find()->where(['NOT', ['id' => $authorId]])->asArray()->all();

        return $this->render('view', [
            'model' => $model,
            'modelAddAuthors' => $modelAddAuthors,
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
        $model = new Books();

        //Current Book add Author
        if ($model->load($this->request->post()) && isset($model->id)) {
            foreach ($model->authorsArr as $authorId) {
                $book_author = new BooksAuthors();
                $book_author->book_id = $model->id;
                $book_author->author_id = $authorId;
                $book_author->save();
            }
            return $this->redirect('index');
        }//New Book Create
        else if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                foreach ($model->authorsArr as $authorId) {
                    $book_author = new BooksAuthors();
                    $book_author->book_id = $model->id;
                    $book_author->author_id = $authorId;
                    $book_author->save();
                }
            }
            return $this->redirect('index');
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

        if (isset($this->request->post()['Authors'])) {
            //Author Updates
            $authors = $this->request->post()['Authors'];
            for ($i = 0; $i < count($authors['id']); $i++) {
                $author = Authors::findOne(['id' => $authors['id'][$i]]);
                $author->name = $authors['name'][$i];
                $author->booksArr = [''];
                $author->save();
            }

            //Book Update
            if ($this->request->isPost && $model->load($this->request->post())) {
                $model->save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        $modelAuthors = Books::find()->where(['id' => $id])->with('authors')->all();

        return $this->render('update', [
            'model' => $model,
            'modelAuthors' => $modelAuthors[0]["authors"],
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
        return $this->redirect(['index']);
    }


    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Books the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Books::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}