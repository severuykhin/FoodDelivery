<?php

use yii\helpers\Html;

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
            
    </div>

</div>
<br>
<br>