<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\VarDumper;

$this->title = 'Отзывы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <h1><?= Html::encode($this->title) ?> <?= Html::a('Добавить', ['reviews/create'], ['class' => 'btn btn-success'])?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'date',
            'text',
            [
                'attribute' => 'active',
                'contentOptions' => ['class' => ''],
                'content' => function ($data) {
                    return $data->active == 1 ? 'Да' : 'Нет';
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>