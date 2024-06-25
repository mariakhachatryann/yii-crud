<?php

use yii\helpers\Html;

$this->title = 'My Books';
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
    <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<div class="row">
    <?php foreach ($books as $book): ?>
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
                    <p class="card-text"><?= Html::encode($book['description']) ?></p>
                    <p class="card-text">Price: $<?= Html::encode($book['price']) ?></p>
                </div>
                <div class="card-footer">
                    <?= Html::a('View Details', ['view', 'id' => $book['id']], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Update', ['update', 'id' => $book['id']], ['class' => 'btn btn-secondary']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $book['id']], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
