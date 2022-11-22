<?php use app\models\Book;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\BookSearch;
use app\models\Author;

use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Book */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->getIdentity()->role != \app\models\User::CUSTOMER_ROLE): ?>
        <p>
            <?= Html::a('Create Books', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endIf ?>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'price',
            'count',
            [
                'attribute' => 'authors',
                'label' => 'Authors',
                'format' => 'text', // Возможные варианты: raw, html
                'content' => function ($data) {
                    $authors = [];
                    foreach ($data->authors as $author) {
                        $authors[] = $author->name;
                    }
                    $authors = implode(", ", $authors);
                    return $authors;
                },
                'filter' => Yii::$app->user->getIdentity()->role == \app\models\User::ADMIN_ROLE ? yii\helpers\ArrayHelper::map(Author::find()->all(), 'id', 'name')
                    : yii\helpers\ArrayHelper::map(Author::find()->where(['id' =>
                        Yii::$app->user->getIdentity()->author_id])->all(), 'id', 'name'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'view' => true,
                    'update' => function ($model) {
                        if (Yii::$app->user->identity->role == \app\models\User::CUSTOMER_ROLE)
                            return false;
                        else
                            return true;
                    },
                    'delete' => function ($model) {
                        if (Yii::$app->user->identity->role == \app\models\User::CUSTOMER_ROLE)
                            return false;
                        else
                            return true;
                    },
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

