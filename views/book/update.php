<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var app\models\Author $modelAuthors */

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

    <?php if(Yii::$app->user->getIdentity()->role ==\app\models\User::ADMIN_ROLE): ?>

    <?= $form->field($model, 'authorsArr')->widget(Select2::className(), [
        'name' => 'authorsArr',
        'data' => ArrayHelper::map(\app\models\Author::find()->all(), 'id', 'name'),
        'options' => [
            'placeholder' => 'Select Authors ...',
            'multiple' => true
        ],
    ]); ?>

    <?php endif ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
