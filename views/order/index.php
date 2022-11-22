<?php

use app\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->identity->role == \app\models\User::CUSTOMER_ROLE
        || Yii::$app->user->identity->role == \app\models\User::ADMIN_ROLE): ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                [
                    'attribute' => 'Customer Name',
                    'label' => 'Customer Name',
                    'format' => 'text', // Возможные варианты: raw, html
                    'content' => function ($data) {
                        return $data->user->login;
                    },
                ],
                [
                    'attribute' => 'Order',
                    'label' => 'Order',
                    'format' => 'text', // Возможные варианты: raw, html
                    'content' => function ($data) {

                        $products = [];

                        foreach ($data->products as $product) {
                            $products[] = $product->book->name;
                            $products[] = $product->count;
                            $products[] = $product->book->price;
                        }
                        $products = implode(" ", $products);
                        return $products;
                    },
                ],
                'total_sum',

            ],
        ]); ?>

    <?php endif ?>

    <?php if (Yii::$app->user->identity->role == \app\models\User::USER_ROLE): ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'name',
                'price',
                [
                    'attribute' => 'Count Customer',
                    'label' => 'Count Customer',
                    'format' => 'text',
                    'content' => function ($data) {
                        // dd($data->products->order);
                        $products = [];
                        $total_sum = 0;
                        foreach ($data->products as $product) {
                            $products[] = $product->count;
                            $products[] = $product->order->user->login;
                            $total_sum += $product->count * $product->book->price;
                            $products[] = $total_sum;
                            $products[] = '<br>';
                        }

                        $products = implode(" ", $products);
                        return $products;

                    },
                ],
            ],
        ]); ?>
    <?php endif ?>

</div>
