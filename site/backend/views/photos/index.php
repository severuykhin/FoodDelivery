<?php

use yii\helpers\Html;
use aquy\thumbnail\Thumbnail;

$this->title = 'Фото лента';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= Html::encode($this->title) ?> <?= Html::a('Добавить', ['photos/create'], ['class' => 'btn btn-success']);?> </h1>

<div class="container-fluid">
    <div class="row">
        <?php if(count($photos > 0)): ?>
            <?php foreach($photos as $model):?>
                <div class="col-lg-3">
                    <div class="thumbnail">
                        <?= Thumbnail::thumbnailImg(
                            Yii::getAlias('@statics/uploads/photos/' . $model->src),
                            400,
                            300,
                            Thumbnail::THUMBNAIL_OUTBOUND
                        ); ?>
                        <div class="caption">
                            <p><?= $model->desc?></p>
                            <p>
                                <span><?= date('d.m.Y', $model->date);?></span>
                                <?php if($model->main == 1): ?>
                                    <span class="label label-primary">На главной</span>
                                <?php endif;?>
                            </p>
                            <p>
                                <?= Html::a('Редактировать', 
                                    [
                                        'photos/update?id=' . $model->id 
                                    ], 
                                    [
                                        'class' => 'btn btn-success'
                                    ]
                                );?>

                                <?= Html::a('Удалить', 
                                    [
                                        'photos/delete?id=' . $model->id 
                                    ], 
                                    [
                                        'class' => 'btn btn-danger',
                                        'data'  => [
                                            'confirm' => 'Вы уверены, что хотите удалить эту фотографию?',
                                            'method'  => 'POST'
                                        ]
                                    ]
                                );?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        <?php endif;?>
    </div>
</div>