<?php

use app\models\Authors;
use conquer\select2\Select2Widget;
use kartik\select2\Select2;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Books $model */


$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
    <div class="book-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
            ],
        ]) ?>

        <div class="book-form">

            <?php $form = ActiveForm::begin(['action' => ['books/create'], 'method' => 'post',]);
            ?>
            <?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
            <?= $form->field($model, 'authorsArr')->widget(Select2::className(), [
                'name' => 'authorsArr',
                'data' => ArrayHelper::map($modelAddAuthors, 'id', 'name'),
                'options' => [
                    'placeholder' => 'Select Authors ...',
                    'multiple' => true
                ],
            ]); ?>

            <div class="form-group">
                <?= Html::submitButton('Add', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>


<?php \app\widgets\AuthorList::begin(['book' => $model]) ?>
<?php \app\widgets\AuthorList::end() ?>