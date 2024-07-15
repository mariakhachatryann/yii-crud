<?php

use common\models\User;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Book $model */

$this->title = 'Books';
$isGuest = Yii::$app->user->isGuest;
$isUser = !$isGuest && !in_array(Yii::$app->authManager->getRole(User::AUTHOR), Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));

\yii\web\YiiAsset::register($this);
?>

<div class="col mb-4">
    <div class="card h-100 shadow-sm">
        <?php
            $imageUrl = Yii::getAlias('@frontendWeb') . $model->imageFile;
            echo Html::img($imageUrl, [
                'class' => 'card-img-top',
                'alt' => 'Book Image',
                'style' => 'height: 350px; object-fit: cover;',
            ]);
        ?>
        <div class="card-body">
            <h5 class="card-title"><?= Html::encode($model->title) ?></h5>
            <p class="card-text"><?= Html::encode($model->description) ?></p>
            <p class="card-text"><strong>Authors:</strong>
<!--                --><?php //foreach ($model->authors as $index => $author): ?>
<!--                    --><?php //= Html::a(Html::encode($author->first_name . ' ' . $author->last_name)) ?>
<!--                    --><?php //if ($index !== count($model->authors) - 1): ?>
<!--                        --><?php //= ',' ?>
<!--                    --><?php //endif; ?>
<!--                --><?php //endforeach; ?>
            </p>
            <p class="card-text"><strong>Publication Year:</strong> <?= Html::encode($model->publication_year) ?></p>
            <p class="card-text"><strong>Price:</strong> $<?= Html::encode($model->price) ?></p>
        </div>
        <?php if ($isUser): ?>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <?= Html::input('text', 'countInput[' . $model->id . ']', '1', ['class' => 'form-control count-input flex-grow-1 me-2', 'data-id' => $model->id, 'placeholder' => 'Enter count', 'min' => 1, 'max' => 10]) ?>
                <?= Html::tag('span', '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 448 512"><path fill="#28a745" d="M256 80c-17.7 0-32 14.3-32 32v112H112c-17.7 0-32 14.3-32 32s14.3 32 32 32h112v112c0 17.7 14.3 32 32 32s32-14.3 32-32V288h112c17.7 0 32-14.3 32-32s-14.3-32-32-32H288V112c0-17.7-14.3-32-32-32z"/></svg>', [
                    'title' => Yii::t('yii', 'Add to Cart'),
                    'class' => 'cursor-pointer book-to-cart add-to-cart-' . $model->id,
                    'data-id' => $model->id,
                    'onclick' => 'addToCart("' . $model->id . '")',
                ]); ?>
            </div>
        <?php endif; ?>
    </div>
</div>