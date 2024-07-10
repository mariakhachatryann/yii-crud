<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrderAddresses */

$this->title = 'Order Address';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-address">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="order-address-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

        <div class="form-group mt-3">
            <?= Html::a('Cancel', ['/cart/index'], ['class' => 'btn btn-danger', 'style' => 'margin-left: 10px;']) ?>
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

        </div>

        <?php ActiveForm::end(); ?>


    </div>

</div>
