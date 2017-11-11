<?php

use yii\helpers\VarDumper;
use yii\helpers\Html;
use aquy\thumbnail\Thumbnail;

?>

<div class="reviews__inner">

  <?php foreach($reviews as $review):?>
      <div class="reviews__item">
        <div class="reviews__info">
          <div class="reviews__name"><?= $review->name?></div>
          <div class="reviews__date"><?= $review->date?></div>
        </div>
        
        <?php if (!empty($review->pic)):?>

        <?php $picPath = Yii::getAlias('@statics/uploads/reviews/' . $review->pic); ?>

        <div class="reviews__img">

          <a href="<?= '/statics/uploads/reviews/' . $review->pic ?>" data-fancybox class="zoompic">

            <?php if(file_exists($picPath)): ?>
              <?= Thumbnail::thumbnailImg(
                  $picPath,
                  300,
                  350,
                  Thumbnail::THUMBNAIL_OUTBOUND,
                  [
                    'alt' => 'Отзыв о работе Кафе Шумовка в Кирове'
                  ]
              ); ?>
            <?php endif;?>

          </a>

        </div>
        <?php else: ?>
          <div class="reviews__text"><?= $review->text ?></div>
        <?php endif;?>
      </div>
  <?php endforeach; ?>
  
</div>