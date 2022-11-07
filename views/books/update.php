<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Books $model */
/** @var app\models\Authors $modelAuthors */

$this->title = 'Update Book: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'id')->hiddenInput(['maxlength' => true])->label('') ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'authorsArr')->widget(Select2::className(), [
        'name' => 'authorsArr',
        'data' => ArrayHelper::map(\app\models\Authors::find()->all(), 'id', 'name'),
        'options' => [
            'placeholder' => 'Select Authors ...',
            'multiple' => true
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
