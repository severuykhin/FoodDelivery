<?php 

use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php $form = ActiveForm::begin([
    'method' => 'post'
]); ?>

<?= $form->field($model, 'title')->textInput([
    'placeholder' => 'Например - Пицца'
]);?>

<?= $form->field($model, 'slug')->textinput([
    'placeholder' => 'Название транслитом для сылок'
])->label('Slug для ссылок - заполнится атоматически при сохранении');?>

<?= $form->field($model, 'description')->widget(Widget::className(), [
    'settings' => [
        'lang' => 'ru',
        'minHeight' => 200,
        'imageUpload' => Url::to(['/category/image-upload']),
        'plugins' => [
            'clips',
            'fullscreen'
        ]
    ]
]); ?>

<?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-success']);?>

<?php ActiveForm::end(); ?>