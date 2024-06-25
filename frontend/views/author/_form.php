<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;


/** @var yii\web\View $this */
/** @var common\models\Book $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'authorsIds')->widget(Select2::class, [
        'data' => \common\models\Author::find()
            ->select(['CONCAT(first_name, " ", last_name) AS full_name', 'id'])
            ->where(['user_id' => Yii::$app->user->id])
            ->indexBy('id')
            ->column(),

        'options' => [
            'multiple' => true,
            'placeholder' => 'Select authors...',
        ],
        'pluginOptions' => [
            'theme' => 'bootstrap-5',
        ],

    ]);
    ?>

    <?= $form->field($model, 'publication_year')->textInput() ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
