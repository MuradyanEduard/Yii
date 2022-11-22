<?php

use app\models\Author;
use app\models\Book;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AuthorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Authors';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if(Yii::$app->user->getIdentity()->role != \app\models\User::CUSTOMER_ROLE): ?>
    <p>
        <?= Html::a('Create Author', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endIf ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            [
                'attribute' => 'books',
                'label' => 'Books',
                'format' => 'text',
                'content' => function ($data) {
                    $books = [];
                    foreach ($data->books as $book) {
                        $books[] = $book->name;
                    }
                    $books = implode(", ", $books);
                    return $books;
                },
                'filter' => yii\helpers\ArrayHelper::map(Book::find()->all(), 'id', 'name'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'view' => true,
                    'update' => function($model){
                        if (Yii::$app->user->identity->role == \app\models\User::CUSTOMER_ROLE)
                            return false;
                        else
                            return true;
                    },
                    'delete' => function($model){
                        if (Yii::$app->user->identity->role == \app\models\User::CUSTOMER_ROLE)
                            return false;
                        else
                            return true;
                    },
                ]
            ],
        ],
    ]); ?>

</div>
