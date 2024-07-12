<?php

use common\models\Book;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($dataProvider->models as $model): ?>
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
                            <?php foreach ($model->authors as $author): ?>
                                <?= Html::a(Html::encode($author->first_name . ' ' . $author->last_name), ['author/view', 'id' => $author->id], ['class' => 'badge bg-primary']) ?>
                            <?php endforeach; ?>
                        </p>
                        <p class="card-text"><strong>Publication Year:</strong> <?= Html::encode($model->publication_year) ?></p>
                        <p class="card-text"><strong>Price:</strong> $<?= Html::encode($model->price) ?></p>
                    </div>
                    <div class="card-footer">
                        <?= Html::a('View Details', ['view', 'id' => $model->_id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Update', ['update', 'id' => $model->_id], ['class' => 'btn btn-secondary']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->_id], [
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

</div>
