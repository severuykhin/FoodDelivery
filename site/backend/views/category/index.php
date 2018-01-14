<?php

use yii\helpers\Html;
use himiklab\sortablegrid\SortableGridView as GridView;

$this->title = 'Категории меню';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <h1><?= Html::encode($this->title) ?> <?= Html::a('Добавить', ['category/create'], ['class' => 'btn btn-success'])?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'title',
            'description',
            'created_at:date',
            'updated_at:date',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>