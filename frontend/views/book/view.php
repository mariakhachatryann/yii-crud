<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\Book $model */

$this->title = $model->title;
$isGuest = Yii::$app->user->isGuest;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view border m-3 p-3">

    <div class="row">
        <div class="col-md-4">
            <?php
            $imageUrl = Yii::getAlias('@frontendWeb') . $model->imageFile;
            echo Html::img($imageUrl, [
                'class' => 'img-fluid rounded mb-3',
                'alt' => 'Book Image',
                'style' => 'max-width: 100%; height: auto;',
            ]);
            ?>
        </div>
        <div class="col-md-8">
            <h3><?= Html::encode($this->title) ?></h3>
            <h5>Description</h5>
            <p><?= Html::encode($model->description) ?></p>
            <p><strong>Publication Year:</strong> <?= Html::encode($model->publication_year) ?></p>
        </div>
    </div>

    <h5>Authors</h5>

    <?= GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider([
            'allModels' => $model->authors,
            'pagination' => false,
        ]),
        'columns' => [
            'id',
            'first_name',
            'last_name',
        ],
        'tableOptions' => ['class' => 'table table-striped'], // Optional: Add Bootstrap table styles
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider([
            'allModels' => [$model],
            'pagination' => false,
        ]),
        'columns' => [
            'id',
            'title',
            'description:ntext',
            'publication_year',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'header' => 'View',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 576 512"><path fill="#007bff" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>', ['book/view', 'id' => $model->id], [
                            'title' => Yii::t('yii', 'View'),
                        ]);
                    },
                ],
                'visibleButtons' => [
                    'view' => !$isGuest,
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{input} {add}',
                'header' => 'Basket Count',
                'buttons' => [
                    'input' => function ($url, $model, $key) {
                        return Html::input('text', 'countInput[' . $model->id . ']', '1', ['class' => 'form-control count-input', 'data-id' => $model->id, 'placeholder' => 'Enter count', 'min' => 1, 'max' => 10]);
                    },
                    'add' => function ($url, $model, $key) {
                        return \yii\helpers\Html::tag('span', '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 448 512"><path fill="#28a745" d="M256 80c-17.7 0-32 14.3-32 32v112H112c-17.7 0-32 14.3-32 32s14.3 32 32 32h112v112c0 17.7 14.3 32 32 32s32-14.3 32-32V288h112c17.7 0 32-14.3 32-32s-14.3-32-32-32H288V112c0-17.7-14.3-32-32-32z"/></svg>', [
                            'title' => Yii::t('yii', 'Add to Basket'),
                            'class' => 'cursor-pointer book-to-basket add-to-basket-' . $model->id,
                            'data-id' => $model->id,
                            'data-url' => 'hello world ' . $model->id,
                            'onclick' => 'addToBasket(' . $model->id . ')',
                        ]);
                    },
                ],
                'visibleButtons' => [
                    'add' => !$isGuest,
                    'input' => !$isGuest,
                ],
            ],
        ],
    ]) ?>

</div>
