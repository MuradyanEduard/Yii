<?php


/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\SignupForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Registration';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="vh-100" style="background-color: #508bfc;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">

                        <h3 class="mb-5">Sign up</h3>

                        <?php $form = ActiveForm::begin([
                            'id' => 'login-form',
                        ]); ?>


                        <div class="form-group">
                            <div class="offset-lg-1 col-lg-11">
                            </div>
                        </div>

                        <div class="form-outline mb-4">
                            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                        </div>

                        <div class="form-outline mb-4">
                            <?= $form->field($model, 'login')->textInput(['autofocus' => true]) ?>
                        </div>

                        <div class="form-outline mb-4">
                            <?= $form->field($model, 'password')->passwordInput() ?>
                        </div>

                        <?= Html::submitButton('Register', ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'login-button']) ?>

                        <hr class="my-4">

                        <?= Html::a('Login', ['auth/login'], ['class' => 'btn btn-primary btn-lg btn-block']) ?>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>