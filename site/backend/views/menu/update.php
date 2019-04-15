<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\jui\AutoComplete;
use himiklab\sortablegrid\SortableGridView as GridView;

$this->title = 'Редактирование пункта меню - ' . $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <h1>
        <?= Html::encode($this->title) ?> 
        <?= Html::a(!empty($model->pic) ? 'Сменить изображение' : 'Добавить изображение', 
            [
            'menu/image?id=' . $model->id
            ], 
            [
                'class' => 'btn btn-success'
            ] )?>
    </h1>

    <div class="container-fluid">
            <?= $this->render('_form', [
                'model' => $model,
                'categories' => $categories
            ]);?>

            <br>
            <br> 

            <?php if($dishModification): ?>

                <h2>Модификации</h2>  

                <?php
                    $listdata=\common\models\DishModification::find()
                    ->select(['value as value', 'value as label'])
                    ->asArray()
                    ->all();
                ?>

                <?php $formMod = ActiveForm::begin(); ?>

                <?= $formMod->field($dishModification, 'id')->label(false)->hiddenInput([
                    'class'=>'jsParamId'
                ]); ?>

                <?= $formMod->field($dishModification, 'dish_id')->label(false)->hiddenInput([
                    'value' => $model->id,
                ]); ?>

                <div class="row">
                
                    <div class="col-lg-4">
                        <?= $formMod->field($dishModification, 'value')->widget(
                            AutoComplete::className(), [
                            'clientOptions' => [
                                'source' => $listdata,
                            ],
                            'options'=>[
                                'class'=>'form-control jsParamValue'
                            ]
                        ]); ?>
                    </div>
                    <div class="col-lg-4">
                        <?= $formMod->field($dishModification, 'price')->textInput(['class'=>'form-control jsParamPrice']); ?>
                    </div>
                    <div class="col-lg-4">
                        <?= $formMod->field($dishModification, 'weight')->textInput(['class'=>'form-control jsParamWeight']); ?>
                    </div>

                </div>
                <?= Html::submitButton('Добавить/редактировать параметр', ['class'=>'btn btn-success']); ?>
                <?php ActiveForm::end(); ?>
                <br>
                <br/>
                <?= GridView::widget([
                    'dataProvider' => $dishModifications,
                    // 'sortableAction' => 'attr',
                    'columns' => [
                        'value',
                        'price',
                        'weight',
                        [
                            'label' => 'Управление',
                            'format' => 'raw',
                            'value' => function($data){
                                return Html::a(
                                    '<span class="glyphicon glyphicon-pencil"></span>',
                                    '',
                                    [
                                        'class' => 'btn btn-xs btn-primary jsEditAttr',
                                        'data' => [
                                            'id' => $data->id,
                                            'value' => $data->value,
                                            'price' => $data->price,
                                            'weight' => $data->weight,
                                            'title' => 'Редактировать',
                                            'params' => [
                                                'update-param' => $data->id
                                            ]
                                        ]
                                    ]
                                ) . ' ' . Html::a(
                                        '<span class="glyphicon glyphicon-trash"></span>',
                                        '',
                                        [
                                            'class' => 'btn btn-xs btn-danger',
                                            'data' => [
                                                'confirm' => 'Удалить параметр ' . $data->value . '?',
                                                'method' => 'post',
                                                'params' => [
                                                    'delete-param' => $data->id
                                                ]
                                            ]
                                        ]
                                    );
                            },
                        ],
                    ],
                ]); ?>
            <?php endif; ?>  
            
    </div>

</div>
<br>
<br>

<?php
$js = <<<JS
$(function() {
    $('.jsEditAttr').on('click', function(e) {
        e.preventDefault();
        $('.jsParamId').val($(this).data('id'));
        $('.jsParamPrice').val(parseInt($(this).data('price')), 10);
        $('.jsParamValue').val($(this).data('value'));
        $('.jsParamWeight').val($(this).data('weight'));
    });
});

// $(function() {
//     $('.jsEditProfit').on('click', function(e) {
//         e.preventDefault();
//         $('.jsProfitId').val($(this).data('id'));
//         $('.jsProfitText').val($(this).data('text'));
//         $('.jsEditProfitSubmit').text('Сохранить');
//         $('.jsCancelEditProfit').hide();
//         $(this).siblings('.jsCancelEditProfit').show();
//     });

//     $('.jsCancelEditProfit').on('click', function (e) {
//         e.preventDefault();
//         $(this).hide();
//         $('.jsProfitId').val('');
//         $('.jsProfitText').val('');
//         $('.jsEditProfitSubmit').text('Добавить');
//     });

// });



JS;

$this->registerJs($js, \yii\web\View::POS_END);