<?php 


use yii\helpers\Html;

use aquy\thumbnail\Thumbnail;

$this->title = 'Редактирование фото';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <?= $this->render('_form', [
                'model' => $model,
                'pages' => $pages
            ]);?>
        </div>
        <div class="col-lg-4">
            <?php if (!empty($model->src)):?>
                <?php if(file_exists(Yii::getAlias('@statics/uploads/photos/' . $model->src))): ?>
                <div class="thumbnail">
                    <?= Thumbnail::thumbnailImg(
                        Yii::getAlias('@statics/uploads/photos/' . $model->src),
                        400,
                        300,
                        Thumbnail::THUMBNAIL_OUTBOUND
                    ); ?>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>