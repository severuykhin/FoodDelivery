<?php

use aquy\thumbnail\Thumbnail;
use yii\helpers\Html;

?>

<div class="store__item">
	<div class="dish">
		<div class="dish__image">
			<?php if(file_exists(Yii::getAlias('@statics/uploads/dishes/' . $item->id . '/' . $item->pic))): ?>
                <a href="<?= '/statics/uploads/dishes/' . $item->id . '/' . $item->pic ?>" data-fancybox class="zoompic zoompic-dark">
                    <?php $thumb = Thumbnail::thumbnailFileUrl(
                        Yii::getAlias('@statics/uploads/dishes/' . $item->id . '/' . $item->pic),
                        290,
                        193,
                        Thumbnail::THUMBNAIL_OUTBOUND,
                        false
                    ); ?>
                    <img alt="Заказать <?= $item->title?> - кафе Шумовка Киров" src="/statics/images/picplaceholder.jpg" data-lazy="<?= $thumb ?>">
                </a>
            <?php else:?>
            <img src="/statics/images/picplaceholder.jpg">
            <?php endif;?>

            <?php if($item->action == 1):?>
            	<div class="dish__labels">
            		<div class="dish__label dish__label-action">Акция!</div>
            	</div>
            <?php endif;?>
		</div>
		<div class="dish__info">
			<div class="dish__title"><?= $item->title ?></div>
			<?= Html::a($categoryTitle, ['/menu#' . $categorySlug], ['class' => 'dish__category']) ?>
			<div class="dish__weight"><?= $item->weight ?></div>
			<?php if(!empty($item->description)):  ?>
				<div class="dish__text"><?= $item->description?></div>				
			<?php endif; ?>
		</div>
		<div class="dish__order">
			<div class="button button__primary" data-role="dish-order">Заказать</div>
			<div class="dish__price"><?= $item->price_actual ?>
				<?php if (!empty($item->price_old)):?>
					<div class="dish__old"><?= $item->price_old ?></div>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>