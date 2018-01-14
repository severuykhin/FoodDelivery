<?php 


use yii\helpers\Html;

$this->title = 'Добавление фото';
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
    </div>
</div>