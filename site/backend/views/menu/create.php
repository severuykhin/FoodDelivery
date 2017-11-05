<?php

use yii\helpers\Html;

$this->title = 'Создание нового пункта меню';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container-fluid">
        
            <?= $this->render('_form', [
                'model' => $model,
                'categories' => $categories
            ]);?>  
            
    </div>

</div>