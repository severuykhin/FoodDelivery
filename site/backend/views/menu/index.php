<?php

use yii\helpers\Html;
use yii\helpers\VarDumper;
use himiklab\sortablegrid\SortableGridView as GridView;


$this->title = 'Пункты меню';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <h1><?= Html::encode($this->title) ?> <?= Html::a('Добавить', ['menu/create'], ['class' => 'btn btn-success'])?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'weight',
            [
                'attribute'      => 'category_id',
                'contentOptions' => ['class' => ''],
                'content'        => function ($data) {
                    return $data->category->title;
                }

            ],
            'price_actual',
            'price_old',
            [
                'attribute'      => 'active',
                'contentOptions' => ['class' => ''],
                'content'        => function($data){
                    return $data->active == 1 ? 'Да' : 'Нет';
                }
            ],
            [
                'attribute' => 'best',
                'contentOptions' => ['class' => ''],
                'content' => function ($data) {
                    return $data->best == 1 ? 'Да' : 'Нет';
                }
            ],
            [
                'attribute' => 'action',
                'contentOptions' => ['class' => ''],
                'content' => function ($data) {
                    return $data->action == 1 ? 'Да' : 'Нет';
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>