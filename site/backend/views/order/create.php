<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CartOrder */

$this->title = 'Create Cart Order';
$this->params['breadcrumbs'][] = ['label' => 'Cart Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
