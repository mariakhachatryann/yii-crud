<?php

use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\web\View;
use yii\widgets\ListView;


/** @var View $this */
/** @var app\models\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var bool $isGuest */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="book-index">

    <h1 class="mb-3"><?= Html::encode($this->title) ?></h1>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => 'view',
    ]) ?>
</div>