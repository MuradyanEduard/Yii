<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Book $model */

$this->title = 'Create Book';
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'count')->textInput(['maxlength' => true]) ?>

    <?php if(Yii::$app->user->getIdentity()->role == \app\models\User::ADMIN_ROLE) : ?>
    <?= $form->field($model, 'authorsArr')->widget(Select2::className(), [
        'name' => 'authArr',
        'data' => ArrayHelper::map(\app\models\Author::find()->asArray()->all(), 'id', 'name'),
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
