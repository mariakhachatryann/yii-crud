<?php
/** @var yii\web\View $this */
/** @var common\models\Order[] $orders */

use yii\helpers\Html;

$this->title = 'My Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1 class="mt-4"><?= Html::encode($this->title) ?></h1>

    <?php foreach ($orders as $order): ?>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Order #<?= Html::encode($order->id) ?></strong>
                    </div>
                    <div>
                        Amount: <?= Yii::$app->formatter->asCurrency($order->transaction->amount) ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h5 class="card-title">Ordered Items:</h5>
                <ul class="list-group list-group-flush">
                    <?php foreach ($order->orderItems as $item): ?>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-2">
                                    <?= Html::img($item->book->imageFile, ['class' => 'img-fluid rounded']) ?>
                                </div>
                                <div class="col-md-6">
                                    <h5><?= Html::encode($item->book->title) ?></h5>
                                    <p><?= Html::encode($item->book->description) ?></p>
                                </div>
                                <div class="col-md-4 d-flex justify-content-between">
                                    <p>Quantity: <?= Html::encode($item->quantity) ?></p>
                                    <p>Price: <?= Yii::$app->formatter->asCurrency($item->book->price) ?></p>
                                    <p>Total: <?= Yii::$app->formatter->asCurrency($item->book->price * $item->quantity) ?></p>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endforeach; ?>
</div>
