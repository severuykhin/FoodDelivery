<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use aquy\thumbnail\Thumbnail;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Меню', 'url' => ['/menu']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
        <?= Html::a(!empty($model->pic) ? 'Сменить изображение' : 'Добавить изображение', 
        [
            'image', 'id' => $model->id
        ], 
        [ 
            'class' => 'btn btn-default'
        ]) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этого пользователя?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7">
            <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'title',
                        'description',
                        'weight',
                        'price_actual',
                        'price_old',
                        [
                            'label'          => 'Активно',
                            'contentOptions' => ['class' => ''],
                            'value'          => $model->active == 1 ? 'Да' : 'Нет'
                        ],
                        [
                            'label'          => 'В блоке лучшие',
                            'contentOptions' => ['class' => ''],
                            'value'          => $model->best == 1 ? 'Да' : 'Нет'
                        ],
                        [
                            'label'          => 'В блоке акции',
                            'contentOptions' => ['class' => ''],
                            'value'          => $model->action == 1 ? 'Да' : 'Нет'
                        ],
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ]) ?>
            </div>
            <?php if(!empty($model->pic)):?>
            <div class="col-lg-5">
                <?= Thumbnail::thumbnailImg(
                    Yii::getAlias('@statics/uploads/dishes/' . $model->id . '/' . $model->pic),
                    500,
                    400,
                    Thumbnail::THUMBNAIL_OUTBOUND
                ); ?>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>