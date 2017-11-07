<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Добавить изображение для - ' . $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container-fluid">  
        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($image, 'image')->fileInput(); ?>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']);?>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="col-lg-7">
                <div class="admin-imageHolder">
                    <?php if (!empty($model->image)): ?>
                        <img src="<?= $mode->pic ?>" alt="Изображение - <?= $model->title ?>">
                    <?php else:?>  
                        <p>Изображение пока не задано</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>