<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Промо страницы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <h1><?= Html::encode($this->title) ?> <?= Html::a('Добавить', ['pages/create'], ['class' => 'btn btn-success'])?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'title',
            'slug',
            'created_at:date',
            'updated_at:date',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>