<?php  

use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;

?>

<?php $form = ActiveForm::begin([
    'method' => 'post'
]); ?>

    <div class="row">
        <div class="col-lg-7">
            <?= $form->field($model, 'title')->textInput([
                'placeholder' => 'Ввведите название'
            ]);?>

            <?= $form->field($model, 'slug')->textInput([
                'placeholder' => 'Не заполнять - сгенерируется автоматически при сохранении'
            ]);?>

            <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
                'data' => $categories,
                'language' => 'ru',
                'options' => ['placeholder' => 'Выберите категорию'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

            <?= $form->field($model, 'description')->widget(Widget::className(), [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 200,
                    'plugins' => [
                        'clips',
                        'fullscreen'
                    ]
                ]
            ]); ?>
        </div>
        <div class="col-lg-5">
            <?= $form->field($model, 'active')->checkbox() ?>

            <?= $form->field($model, 'best')->checkbox() ?>

            <?= $form->field($model, 'action')->checkbox() ?>

            <?= $form->field($model, 'weight')->textInput([
                'placeholder' => '100 гр'
            ]);?>

            <?= $form->field($model, 'price_actual')->textInput([
                'placeholder' => '100 Р'
            ]);?>

            <?= $form->field($model, 'price_old')->textInput([
                'placeholder' => '100 Р'
            ]);?>
        </div>
    </div>

<?= Html::submitButton($model->isNewRecord ? 'Сохранить' : 'Редактировать', ['class' => 'btn btn-success']);?>

<?php ActiveForm::end(); ?>