<?php
use yii\helpers\Html;

$this->title = 'Ordered Books';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="row">
    <?php foreach ($booksInBasket as $book): ?>
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <?php
                echo Html::img($book['imageFile'], [
                    'class' => 'card-img-top img-fluid',
                    'alt' => Html::encode($book['title']),
                    'style' => 'height: 300px; object-fit: cover;',
                ]);
                ?>
                <div class="card-body">
                    <h5 class="card-title"><?= Html::encode($book['title']) ?></h5>
                    <p class="card-text">Price: $<?= Html::encode($book['price']) ?></p>
                    <p class="card-text">Ordered Count: <?= Html::encode($book['count']) ?></p>
                    <p class="card-text">Order Sum: $<?= Html::encode($book['count'] * $book['authorShare']) ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
