<?php

use yii\helpers\Html;

$this->title = 'Редактирование промо страницы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
            <?= $this->render('_form', [
                'model' => $model
            ]);?>  
            </div>
        </div>
    </div>

</div>