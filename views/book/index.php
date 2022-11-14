<?php use yii\helpers\Html;
use yii\grid\GridView;
use app\models\BookSearch;
use app\models\Author;

use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Book */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Create Books', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
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
                'filter' => Yii::$app->user->getIdentity()->role == 0? yii\helpers\ArrayHelper::map(Author::find()->all(), 'id', 'name')
                    : yii\helpers\ArrayHelper::map(Author::find()->where(['id' =>
                    Yii::$app->user->getIdentity()->author_id])->all(), 'id', 'name'),
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
