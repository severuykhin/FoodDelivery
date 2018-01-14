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
    'placeholder' => 'Заголовок'
]);?>

<?= $form->field($model, 'slug')->textinput([
    'placeholder' => 'Заголовок транслитом для сылок'
])->label('Slug для ссылок - заполнится атоматически при сохранении');?>

<?= $form->field($model, 'content')->widget(Widget::className(), [
    'settings' => [
        'lang' => 'ru',
        'minHeight' => 200,
        'imageUpload' => Url::to(['/pages/image-upload']),
        'plugins' => [
            'clips',
            'fullscreen'
        ]
    ]
]); ?>

<?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-success']);?>

<?php ActiveForm::end(); ?>