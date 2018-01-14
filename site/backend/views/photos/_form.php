<?php

use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin([
    'method' => 'POST'
]); ?>

<?= $form->field($model, 'title')->textInput();?>

<?= $form->field($model, 'desc')->textarea();?>

<?= $form->field($model, 'tempDate')->textInput([
    'class' => 'datepicker-here form-control'
]);?>

<?= $form->field($model, 'main')->checkbox(); ?>

<?= $form->field($model, 'feed')->checkbox(); ?>

<?= $form->field($model, 'about__block')->checkbox(); ?>

<?= $form->field($model, 'banner')->checkbox();?>

<?= $form->field($model, 'url')->widget(Select2::classname(), [
    'data' => $pages,
    'language' => 'ru',
    'options' => ['placeholder' => 'Связанная страница'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>

<?= $form->field($model, 'image')->fileInput();?>

<?= Html::submitButton( 'Сохранить',  [ 'class' => 'btn btn-success' ]);?>

<?php ActiveForm::end();?>