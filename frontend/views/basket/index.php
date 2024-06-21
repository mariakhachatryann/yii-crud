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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'value' => function ($model) {
                    return $model->book->title;
                },
            ],
            [
                'attribute' => 'Description',
                'value' => function ($model) {
                    return $model->book->description;
                },
            ],
            [
                'attribute' => 'Authors',
                'value' => function ($model) {
                    $authorNames = [];
                    foreach ($model->book->authors as $author) {
                        $authorNames[] = $author->first_name . ' ' . $author->last_name;
                    }
                    return implode(', ', $authorNames);
                },
            ],
            [
                'attribute' => 'Count',
                'value' => function ($model) {
                    return $model->count;
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Basket $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'user_id' => $model->user_id, 'book_id' => $model->book_id]);
                 },
                'visibleButtons' => [
                    'update' => false,
                    'view' => false,
                ],
            ],
        ],
    ]); ?>


</div>
