<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= Url::toRoute('book/index'); ?>" class="brand-link">
        <img src="<?= $assetDir ?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $assetDir ?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="<?= Url::toRoute('book/index'); ?>" class="d-block"><?= Yii::$app->user->identity->login ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php if (Yii::$app->user->identity->role == \app\models\User::ADMIN_ROLE): ?>
                <?php echo \hail812\adminlte\widgets\Menu::widget([
                    'items' => [
                        ['label' => 'Book List', 'icon' => 'square', 'url' => ['/book']],
                        ['label' => 'Book Create', 'icon' => 'square', 'url' => ['/book/create']],
                        ['label' => 'Author List', 'icon' => 'circle', 'url' => ['/author']],
                        ['label' => 'Author Create', 'icon' => 'circle', 'url' => ['/author/create']],
                        ['label' => 'Order List', 'icon' => 'circle', 'url' => ['/order']],
                        ['label' => 'Log out', 'icon' => 'dot-circle',
                            'template' => ""
                                . Html::beginForm(['/auth/logout'])
                                . Html::submitButton(
                                    'Logout (' . Yii::$app->user->identity->login . ')',
                                    ['class' => 'nav-link btn btn-link logout'])
                                . Html::endForm(),
                        ],
                    ]
                ]);
                ?>
            <?php endif ?>
            <?php if (Yii::$app->user->identity->role == \app\models\User::USER_ROLE): ?>
                <?php echo \hail812\adminlte\widgets\Menu::widget([
                    'items' => [
                        ['label' => 'Book List', 'icon' => 'square', 'url' => ['book/index']],
                        ['label' => 'Book Create', 'icon' => 'square', 'url' => ['book/create']],
                        ['label' => 'Order List', 'icon' => 'circle', 'url' => ['/order']],
                        ['label' => 'Log out', 'icon' => 'dot-circle',
                            'template' => ""
                                . Html::beginForm(['/auth/logout'])
                                . Html::submitButton(
                                    'Logout (' . Yii::$app->user->identity->login . ')',
                                    ['class' => 'nav-link btn btn-link logout'])
                                . Html::endForm(),
                        ],
                    ]
                ]);
                ?>
            <?php endif ?>
            <?php if (Yii::$app->user->identity->role == \app\models\User::CUSTOMER_ROLE): ?>
                <?php echo \hail812\adminlte\widgets\Menu::widget([
                    'items' => [
                        ['label' => 'Book List', 'icon' => 'square', 'url' => ['book/index']],
                        ['label' => 'Author List', 'icon' => 'square', 'url' => ['author/index']],
                        ['label' => 'Order List', 'icon' => 'circle', 'url' => ['/order']],
                        ['label' => 'Log out', 'icon' => 'dot-circle',
                            'template' => ""
                                . Html::beginForm(['/auth/logout'])
                                . Html::submitButton(
                                    'Logout (' . Yii::$app->user->identity->login . ')',
                                    ['class' => 'nav-link btn btn-link logout'])
                                . Html::endForm(),
                        ],
                    ]
                ]);
                ?>
            <?php endif ?>

            <?php /*echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                ]
            ]);*/
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>



