<?php

use common\models\Book;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\web\View;

/** @var View $this */
/** @var app\models\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var bool $isGuest */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;

$isGuest = Yii::$app->user->isGuest;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'title',
            'description:ntext',
            [
                'attribute' => 'Authors',
                'value' => function ($model) {
                    $authorNames = [];
                    foreach ($model->authors as $author) {
                        $authorNames[] = $author->first_name . ' ' . $author->last_name;
                    }
                    return implode(', ', $authorNames);
                },
            ],
            'publication_year',
            [
                'class' => ActionColumn::class,
                'template' => '{view} {add}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 576 512"><path fill="#007bff" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>', ['book/view', 'id' => $model->id], [
                            'title' => Yii::t('yii', 'View'),
                        ]);
                    },
                    'add' => function ($url, $model, $key) {
                        return Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 448 512"><path fill="#28a745" d="M256 80c-17.7 0-32 14.3-32 32v112H112c-17.7 0-32 14.3-32 32s14.3 32 32 32h112v112c0 17.7 14.3 32 32 32s32-14.3 32-32V288h112c17.7 0 32-14.3 32-32s-14.3-32-32-32H288V112c0-17.7-14.3-32-32-32z"/></svg>', ['basket/create', 'id' => $model->id], [
                            'title' => Yii::t('yii', 'Add to Basket'),
                        ]);
                    },
                ],
                'visibleButtons' => [
                    'view' => !$isGuest,
                    'add' => !$isGuest,
                ],
            ],
        ],
    ]); ?>

</div>
