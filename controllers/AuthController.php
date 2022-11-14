<?php

namespace app\controllers;

use app\models\Author;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\rbac\DbManager;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class AuthController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['book/index']);
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['book/index']);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect('index');
    }

    public function actionRegistration()
    {
        $user = new User();

        if ($this->request->isPost && $user->load($this->request->post())) {
            $author = new Author();
            $author->name = $user->login;
            $author->booksArr = [''];
            $author->save();

            $user->role = 1;
            $user->author_id = Yii::$app->db->getLastInsertID();
            $user->authkey = "test100key";
            $user->accessToken = "100-token";
            $user->save();

            $model = new LoginForm();
            $model->username = $user->login;
            $model->password = $user->password;
            $model->login();

            return $this->redirect(['book/index']);
        } else {
            $user->loadDefaultValues();
        }

        return $this->render('Registration', [
            'model' => $user,
        ]);
    }

}
