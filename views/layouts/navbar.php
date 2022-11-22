<?php

use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Html;

?>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <?= Html::a('Book List', ['book/index'], ['class' => 'nav-link']) ?>
        </li>
        <?php if (Yii::$app->user->identity->role != \app\models\User::CUSTOMER_ROLE): ?>
            <li class="nav-item d-none d-sm-inline-block">
                <?= Html::a('Book Create', ['book/create'], ['class' => 'nav-link']) ?>
            </li>
        <?php endif ?>
        <?php if (Yii::$app->user->identity->role != \app\models\User::USER_ROLE): ?>

            <li class="nav-item d-none d-sm-inline-block">
                <?= Html::a('Author List', ['author/index'], ['class' => 'nav-link']) ?>
            </li>
            <?php if (Yii::$app->user->identity->role != \app\models\User::CUSTOMER_ROLE): ?>
                <li class="nav-item d-none d-sm-inline-block">
                    <?= Html::a('Author Create', ['author/create'], ['class' => 'nav-link']) ?>
                </li>
            <?php endif ?>
        <?php endif ?>
        <li class="nav-item d-none d-sm-inline-block">
            <?= Html::a('Order List', ['/order'], ['class' => 'nav-link']) ?>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <?= Html::beginForm(['/auth/logout']); ?>
            <?= Html::submitButton(
                'Logout (' . Yii::$app->user->identity->login . ')',
                ['class' => 'nav-link btn btn-link logout']); ?>
            <?= Html::endForm(); ?>
        </li>

    </ul>
</nav>
<!-- /.navbar -->
