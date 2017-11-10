<?php  

use frontend\widgets\Dishes;

?>

<div class="container">
    <div class="content__title-h1">
        <h1> <?= $category->title ?> </h1>
    </div>
    <?= Dishes::widget([
        'items' => $dishes
    ]);?>

    <div class="content__description">
        <?= $category->description?>
    </div>
</div>