<?php

namespace app\controllers;

use app\models\Book;
use app\models\BookSearch;
use app\models\Order;
use app\models\OrderProduct;
use app\models\OrderSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\BaseJson;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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
     * Lists all Order models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity->role == \app\models\User::USER_ROLE) {
            $searchModel = new BookSearch();
            $dataProvider = $searchModel->searchByAuthorId($this->request->queryParams, Yii::$app->user->identity->id);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            $searchModel = new OrderSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single Order model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if ($this->request->isPost) {
            $order = new Order();
            $order->total_sum = $this->request->post()['total_sum'];
            $order->user_id = Yii::$app->user->identity->id;
            $order->save();

            $cookieArr = [];

            if (Yii::$app->getRequest()->getCookies()->has('products')) {
                $cookieArr = Yii::$app->getRequest()->getCookies()->getValue('products');
            }

            foreach ($cookieArr as $key => $cookie) {
                $book = Book::findOne($cookie['id']);

                $product = new OrderProduct();
                $product->order_id = $order->id;
                $product->book_id = $cookie['id'];
                $product->count = $cookie['count'];
                $product->price = $book->price * $cookie['count'];
                $product->save();
                $book->count -= intval($cookie['count']);

                if ($book->count < 0)
                    $book->count = 0;

                $book->authorsArr = [''];
                $book->save();
            }

            $cookie = new \yii\web\Cookie([
                'name' => 'products',
                'value' => [],
            ]);

            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        return $this->redirect('/book');
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    protected function findModel($id)
    {
        if (($model = Order::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAddProduct()
    {
        $model = new Book();
        $model->load($this->request->post());
        $book = Book::findOne($model->id);

        $cookieArr = [];

        if (Yii::$app->getRequest()->getCookies()->has('products')) {
            $cookieArr = Yii::$app->getRequest()->getCookies()->getValue('products');
        }

        $cond = false;

        foreach ($cookieArr as $key => $cookie) {
            if ($model->id == $cookie['id']) {
                $cond = true;

                if ($book->count <= ($cookie['count'] + $model->count)) {
                    $cookieArr[$key]['count'] = $book->count;
                } else {
                    $cookieArr[$key]['count'] = $cookie['count'] + $model->count;
                }

                break;
            }
        }

        if (!$cond) {
            if ($book->count <= ($model->count)) {
                array_push($cookieArr, [
                    'id' => $model->id,
                    'count' => ($book->count)
                ]);
            } else {
                array_push($cookieArr, [
                    'id' => $model->id,
                    'count' => ($model->count)
                ]);
            }

        }

        $cookie = new \yii\web\Cookie([
            'name' => 'products',
            'value' => $cookieArr,
        ]);

        Yii::$app->getResponse()->getCookies()->add($cookie);
        $this->redirect('/book');
    }

    public function actionRemoveProduct()
    {
        $id = $this->request->post()['id'];
        $cookieArr = [];

        if (Yii::$app->getRequest()->getCookies()->has('products')) {
            $cookieArr = Yii::$app->getRequest()->getCookies()->getValue('products');
        }

        foreach ($cookieArr as $key => $cookie) {
            if ($id == $cookie['id']) {
                unset($cookieArr[$key]);
            }
        }

        $cookie = new \yii\web\Cookie([
            'name' => 'products',
            'value' => $cookieArr,
        ]);

        Yii::$app->getResponse()->getCookies()->add($cookie);
        $this->redirect('/book');
    }


}

