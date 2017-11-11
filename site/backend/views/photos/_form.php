<?php

use yii\widgets\ActiveForm;

use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin([
    'method' => 'POST'
]); ?>

<?= $form->field($model, 'desc')->textarea();?>

<?= $form->field($model, 'tempDate')->textInput([
    'class' => 'datepicker-here form-control'
]);?>

<?= $form->field($model, 'main')->checkbox();?>

<?= $form->field($model, 'image')->fileInput();?>

<?= Html::submitButton( 'Сохранить',  [ 'class' => 'btn btn-success' ]);?>

<?php ActiveForm::end();?>