<?php

use aquy\thumbnail\Thumbnail;

?>

<div class="content__block" style="background: url(/statics/images/wood-background-2940.jpeg); background-size: cover;">
      <div class="container">
        <div class="actions" data-role="actions">

          <?php foreach ($actionDishes as $dish): ?>

          <div class="actions__item">
            <div class="actions__item-inner">
              <div class="actions__info">
                <div class="actions__title"><?= $dish->title ?></div>
                <div class="actions__dishWeight"><?= $dish->weight ?></div>
                <div class="actions__text"><?= $dish->description?></div>
                <div class="actions__aside">
                  <div class="button button-shadow button__primary button__primary-big" data-role="dish-order">Хочу</div>
                  <div class="dish__price"><?= $dish->price_actual?>
                    <?php if (!empty($dish->price_old)): ?>
                      <div class="dish__old"><?= $dish->price_old ?></div>
                    <?php endif;?>
                  </div>
                </div>
              </div>
              <div class="actions__img">

                <div class="actions__img-inner">
                <?php if(file_exists(Yii::getAlias('@statics/uploads/dishes/' . $dish->id . '/' . $dish->pic))): ?>
                  <?= Thumbnail::thumbnailImg(
                      Yii::getAlias('@statics/uploads/dishes/' . $dish->id . '/' . $dish->pic),
                      500,
                      300,
                      Thumbnail::THUMBNAIL_OUTBOUND
                  ); ?>
                <?php else:?>
                  <img src="/statics/images/dish-placeholder.jpg"></div>
                <?php endif;?>
                </div>

              </div>
            </div>
          </div>

          <?php endforeach;?>
        </div>
      </div>
    </div>