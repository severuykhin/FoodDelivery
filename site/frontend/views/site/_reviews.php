<?php

use yii\helpers\VarDumper;
use yii\helpers\Html;
use aquy\thumbnail\Thumbnail;

?>

<?php foreach($reviews as $review):?>
    <div class="reviews__item">
      <div class="reviews__info">
        <div class="reviews__name"><?= $review->name?></div>
        <div class="reviews__date"><?= $review->date?></div>
      </div>
      <div class="reviews__text"><?= $review->text ?>
        

      <?php if (!empty($review->pic)):?>

        <?php $picPath = Yii::getAlias('@statics/uploads/reviews/' . $review->pic); ?>

        <div class="reviews__img">

          <a href="<?= '/statics/uploads/reviews/' . $review->pic ?>" data-fancybox > Смотреть отзыв
          </a>

        </div>
      <?php endif;?>


      </div>
    </div>
<?php endforeach; ?>
  
