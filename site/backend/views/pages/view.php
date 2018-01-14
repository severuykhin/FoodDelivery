<?php

use yii\helpers\Html;

$this->title = 'Просмотр промо-страницы: ' . $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="container-fluid">
        <?= Html::a('Редактировать', ['pages/update?id=' . $model->id], ['class' => 'btn btn-success']);?>
        <?= Html::a('Удалить', ['pages/delete?id=' . $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Вы уверены, что хотите удалить эту страницу?',
                'method'  => 'POST'
            ]
        ]);?>
    </div>
    <br>
    <br>
    <div class="container">
        <?= $model->content ?>
    </div>

</div>