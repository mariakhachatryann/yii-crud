<?php

use yii\helpers\Html;

$this->title = 'Ordered Books';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="container">
    <?php foreach ($ordersData as $order): ?>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Order #<?= Html::encode($order['orderId']) ?>
            </div>
            <div class="card-body">
                <h5 class="card-title">Ordered Items:</h5>
                <ul class="list-group">
                    <?php foreach ($order['orderItems'] as $item): ?>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-2">
                                    <?= Html::img($item['imageFile'], ['class' => 'img-fluid']) ?>
                                </div>
                                <div class="col-md-6">
                                    <h5><?= Html::encode($item['title']) ?></h5>
                                    <p><?= Html::encode($item['description']) ?></p>
                                </div>
                                <div class="col-md-4">
                                    <p>Quantity: <?= Html::encode($item['quantity']) ?></p>
                                    <p>Price: <?= Yii::$app->formatter->asCurrency($item['price']) ?></p>
                                    <p>
                                        Total: <?= Yii::$app->formatter->asCurrency($item['quantity'] * $item['price']) ?></p>
                                    <p>Author Share: <?= Yii::$app->formatter->asCurrency($item['authorShare']) ?></p>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endforeach; ?>

    <?php
    $totalEarnings = 0;
    foreach ($ordersData as $order) {
        foreach ($order['orderItems'] as $item) {
            $totalEarnings += $item['authorShare'];
        }
    }
    ?>

    <div class="text-center mt-4">
        <h4>Total Author Earnings: <?= Yii::$app->formatter->asCurrency($totalEarnings) ?></h4>
    </div>
</div>
