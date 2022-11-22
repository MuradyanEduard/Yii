<?php
/* @var $content string */

use app\models\Book;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<div class="show_cart" style="position:fixed; z-index: 9999; right: 0; cursor:pointer; top: 10%; width: 60px; border-radius: 8px 0px 0px 8px; background: #0a73bb; padding-left: 5px;"><?php echo Html::img('@web/img/shopping-cart.png', ['width' => '32px']) ?></div>
<?php if(Yii::$app->user->identity->role == \app\models\User::CUSTOMER_ROLE): ?>
<div class="products_basket_window" style="">
    <div class="col-12">
        <div class="hide_cart" style="float:right; z-index: 9999; cursor:pointer;margin: 20px;">
            <?php echo Html::img('@web/img/remove.png', ['width' => '32px']) ?>
        </div>
        <table>
            <tr>
                <th>Name</th>
                <th>Count</th>
                <th>Price</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php
            $cookieArr = [];
            $totalSum = 0;

            if (Yii::$app->getRequest()->getCookies()->has('products')) {
                $cookieArr = Yii::$app->getRequest()->getCookies()->getValue('products');
            }

            foreach ($cookieArr as $key => $cookie) {

                $book = Book::findOne($cookieArr[$key]['id']);
                $totalSum += $book->price * $cookieArr[$key]['count'];
                ?>
                <tr>
                    <td> <?= $book->name ?></td>
                    <td> <?= $cookieArr[$key]['count'] ?></td>
                    <td> <?= $book->price ?></td>
                    <td><?= $book->price * $cookieArr[$key]['count'] ?></td>
                    <td>
                        <?= Html::beginForm(['/order/remove-product']); ?>
                        <?= Html::hiddenInput('id', $cookieArr[$key]['id']); ?>
                        <?= Html::submitButton(
                            Html::img('@web/img/remove.png', ['width' => '32px']),
                            [
                                    'style' => ['background' => 'none','border'=>'none'],
                                ]); ?>
                        <?= Html::endForm(); ?>
                    </td>

                </tr>

            <?php } ?>

        </table>
        <div> Total sum: <?= $totalSum ?></div>
        <div>
            <?= Html::beginForm(['/order/create']); ?>
            <?= Html::hiddenInput('total_sum', $totalSum);?>
            <?= Html::submitButton(
                Html::img('@web/img/buy-button.png', ['width' => '80px']),
                ['class' => 'nav-link btn btn-link logout']);?>
            <?= Html::endForm();?>
        </div>
    </div>
</div>
<?php endif; ?>
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content col-11">
        <div class="row">
            <div class="col-12 col-lg-12" style="padding-left:40px;margin-top:40px;">
                <div class="row">
                    <div class="col-12">
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
</div>