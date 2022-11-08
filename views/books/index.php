<?php use yii\helpers\Html;
use yii\grid\GridView;
use app\models\BooksSearch;
use app\models\Authors;

use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Books */
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
                'filter' => yii\helpers\ArrayHelper::map(Authors::find()->all(), 'id', 'name'),
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>


    <!--             [
            'class' => ActionColumn::className(),
            'urlCreator' => function ($action, Books $model, $key, $index, $column) {
                if ($action == 'delete')
                    return Url::to(['books/' . $action, 'id' => $model]);
                else
                    return Url::to(['books/' . $action, 'id' => $model->id]);
            }
        ], -->