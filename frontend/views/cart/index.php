<?php
use common\models\Cart;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var \frontend\models\CartSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books Cart';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cart-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($dataProvider->totalCount > 0): ?>
        <div class="row">
            <?php foreach ($dataProvider->getModels() as $model): ?>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <?= Html::encode($model->book->title) ?>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <?= Html::img(Yii::getAlias('@frontendWeb') . $model->book->imageFile, [
                                        'class' => 'img-fluid',
                                        'alt' => 'Book Image'
                                    ]) ?>
                                </div>
                                <div class="col-md-8">
                                    <p><strong>Description:</strong> <?= Html::encode($model->book->description) ?></p>
                                    <p><strong>Authors:</strong>
                                        <?php foreach ($model->book->authors as $author): ?>
                                            <?= Html::encode($author->first_name . ' ' . $author->last_name) ?><br>
                                        <?php endforeach; ?>
                                    </p>
                                    <p><strong>Price:</strong> <?= Yii::$app->formatter->asCurrency($model->book->price) ?></p>
                                    <p><strong>Quantity:</strong> <?= Html::encode($model->quantity) ?></p>
                                    <p><strong>Total:</strong> <?= Yii::$app->formatter->asCurrency($model->book->price * $model->quantity) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <?= Html::a('Remove', ['delete', 'book_id' => $model->book_id], [
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'confirm' => 'Are you sure you want to remove this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Your cart is empty.
        </div>
    <?php endif; ?>

    <?php if ($dataProvider->totalCount > 0): ?>
        <div class="row justify-content-end mt-3">
            <div class="col-auto">
                <?= Html::a('Checkout', ['/order/checkout'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    <?php endif; ?>
</div>