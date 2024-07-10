<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Author $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="col mb-4">
    <div class="card h-100 shadow-sm d-flex flex-row">
        <?php
        $imageUrl = Yii::getAlias('@frontendWeb') . $model->imageFile;
        echo Html::img($imageUrl, [
            'class' => 'card-img-top',
            'alt' => 'Book Image',
            'style' => 'height: 350px; object-fit: cover; width: 500px;',
        ]);
        ?>
        <div class="card-body">
            <h5 class="card-title"><?= Html::encode($model->title) ?></h5>
            <p class="card-text"><?= Html::encode($model->description) ?></p>
            <p class="card-text"><strong>Authors:</strong>
                <?php foreach ($model->authors as $index => $author): ?>
                    <?= Html::a(Html::encode($author->first_name . ' ' . $author->last_name)) ?>
                    <?php if ($index !== count($model->authors) - 1): ?>
                        <?= ',' ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </p>
            <p class="card-text"><strong>Publication Year:</strong> <?= Html::encode($model->publication_year) ?></p>
            <p class="card-text"><strong>Price:</strong> $<?= Html::encode($model->price) ?></p>
        </div>

    </div>
</div>