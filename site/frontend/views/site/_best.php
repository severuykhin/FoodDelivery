<?php  

use aquy\thumbnail\Thumbnail;
use yii\helpers\Html;

?>

<div class="best">
    <div class="container-fluide">
        <div class="best__title">
            <h2><span>Любимые блюда наших гостей</span>
                <?= Html::a('Всё меню', ['menu/category', 'slug' => 'all'], ['class' => 'button-secondary']); ?>
            </h2>
        </div>
        <div class="best__inner">
        <?php foreach($bestDishes as $index => $item): ?>
            <div class="best__item">
                <?= $this->render('../menu/_card', [ 
                    'item' => $item,
                    'categoryId' => $item->category->id,
                    'index' => $index
                ])?>
            </div>
        <?php endforeach;?>
        </div>
  </div>
</div>