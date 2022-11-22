<?php

use app\models\Author;
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
/** @var app\models\Book $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'price',
            'count'
        ],
    ]) ?>

</div>


<?php \app\widgets\AuthorList::begin(['book' => $model]) ?>
<?php \app\widgets\AuthorList::end() ?>

<div class="form-group">
    <?php $form = ActiveForm::begin(['action' => 'order/add', 'method' => 'post']); ?>
    <?= $form->field($model, 'id')->hiddenInput(['maxlength' => true])->label('') ?>
    <?= $form->field($model, 'count')->textInput(['maxlength' => true]) ?>
    <?= Html::submitButton('Add Product', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>
</div>

