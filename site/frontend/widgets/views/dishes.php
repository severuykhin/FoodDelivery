<?php

use aquy\thumbnail\Thumbnail;

?>

<div class="best__inner">

    <?php foreach($items as $item): ?>
        <div class="best__item best__item-category">
            <div class="dish">
                <div class="dish__image">
                    <?php if(file_exists(Yii::getAlias('@statics/uploads/dishes/' . $item->id . '/' . $item->pic))): ?>
                    <?= Thumbnail::thumbnailImg(
                        Yii::getAlias('@statics/uploads/dishes/' . $item->id . '/' . $item->pic),
                        290,
                        193,
                        Thumbnail::THUMBNAIL_OUTBOUND,
                        [
                            'alt' => 'Заказать ' . $item->title . ' в Кирове'
                        ]
                    ); ?>
                    <?php else:?>
                    <img src="/statics/images/dishplaceholder.jpg"></div>
                    <?php endif;?>
                </div>
                    <div class="dish__info">
                    <div class="dish__title"><?= $item->title ?></div>
                    <div class="dish__weight"><?= $item->weight ?></div>
                    <div class="dish__text"><?= $item->description ?></div>
                </div>
                <div class="dish__order">
                    <div class="button button__primary" data-role="dish-order">Заказать</div>
                    <div class="dish__price"><?= $item->price_actual?>
                        <?php if (!empty($item->price_old)): ?>
                            <div class="dish__old"><?= $item->price_old ?></div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;?>

</div>