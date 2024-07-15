<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ListView;


/** @var View $this */
/** @var app\models\ElasticSearchBookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var bool $isGuest */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="book-index">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-3"><?= Html::encode($this->title) ?></h1>
        <form class="d-flex" action="/book/search" method="get">
            <input name="title" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>


    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => 'view',
        'layout' => "{items}",
        'options' => [
            'class' => 'row row-cols-1 row-cols-md-3 g-4'
        ],
    ]) ?>
</div>