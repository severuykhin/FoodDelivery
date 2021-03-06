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
            [
                'attribute'      => 'text',
                'contentOptions' => ['class' => ''],
                'content'        => function ($data) {
                    return !empty($data->pic) ? 'Фото-отзыв' : $data->text;
                }
            ],
            [
                'attribute'      => 'active',
                'contentOptions' => ['class' => ''],
                'content'        => function ($data) {
                    return $data->active == 1 ? 'Да' : 'Нет';
                }
            ],
            [
                'class'         => 'yii\grid\ActionColumn',
                'header'        =>'Действия', 
                'headerOptions' => ['width' => '80'],
                'template'      => '{update} {delete}',
            ],
        ],
    ]); ?>

</div>