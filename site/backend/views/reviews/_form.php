<?php  

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use aquy\thumbnail\Thumbnail;

?>

<div class="row">
    <div class="col-lg-7">
        <?php $form = ActiveForm::begin([
            'method' => 'post'
        ]); ?>

        <?= $form->field($model, 'name')->textInput([
            'placeholder' => 'Автор'
        ]);?>

        <?= $form->field($model, 'date')->textINput([
            'placeholder' => 'Дата',
            'class'       => 'datepicker-here form-control' 
        ]);?>

        <?= $form->field($model, 'text')->textarea();?>

        <?= $form->field($model, 'active')->checkbox()?>

        <?= $form->field($model, 'image')->fileInput(); ?>

        <?= Html::submitButton($model->isNewRecord ? 'Сохранить' : 'Редактировать', ['class' => 'btn btn-success']);?>

        <?php ActiveForm::end(); ?>
        <br>
    </div>
    <div class="col-lg-5">
        <?php if (!empty($model->pic)): ?>
            <?= Thumbnail::thumbnailImg(
                Yii::getAlias('@statics/uploads/reviews/' . $model->pic),
                500,
                400,
                Thumbnail::THUMBNAIL_OUTBOUND
            ); ?>    
        <?php endif; ?>
    </div>
</div>