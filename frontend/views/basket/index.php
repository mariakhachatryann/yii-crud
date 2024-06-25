<?php

use common\models\Basket;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;


/** @var yii\web\View $this */
/** @var \frontend\models\BasketSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books Basket';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="basket-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'label' => 'Title',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::tag('p', Html::encode($model->book->title))
                        .
                        Html::img(Yii::getAlias('@frontendWeb') . $model->book->imageFile, [
                            'class' => 'img-thumbnail',
                            'alt' => 'Book Image',
                            'style' => 'max-width: 100px; height: auto;'
                        ]);
                },
            ],
            [
                'attribute' => 'Description',
                'label' => 'Description',
                'value' => function ($model) {
                    return Html::encode($model->book->description);
                },
            ],
            [
                'attribute' => 'Authors',
                'label' => 'Authors',
                'value' => function ($model) {
                    $authorNames = [];
                    foreach ($model->book->authors as $author) {
                        $authorNames[] = Html::tag('p', Html::encode($author->first_name . ' ' . $author->last_name));
                    }
                    return implode('', $authorNames);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'Price',
                'label' => 'Price',
                'value' => function ($model) {
                    return '$' . Html::encode($model->book->price);
                },
            ],
            [
                'attribute' => 'Count',
                'label' => 'Count',
                'value' => function ($model) {
                    return 'x' . Html::encode($model->count);
                },
            ],            [
                'attribute' => 'Total',
                'label' => 'Total',
                'value' => function ($model) {
                    return '$' . Html::encode($model->book->price) * $model->count;
                },
            ],
            [
                'class' => ActionColumn::class,
                'header' => 'Remove',
                'urlCreator' => function ($action, Basket $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'user_id' => $model->user_id, 'book_id' => $model->book_id]);
                },
                'visibleButtons' => [
                    'update' => false,
                    'view' => false,
                ],
            ],
        ],
        'tableOptions' => ['class' => 'table table-striped table-bordered'],
    ]); ?>

</div>

