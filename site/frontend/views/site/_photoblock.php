<?php use aquy\thumbnail\Thumbnail; ?>

<div class="photoblock ">
	<?php foreach($photos as $photo):?>
	<div class="photoblock__item">
		<?php $src = Yii::getAlias('@statics/uploads/photos/' . $photo['src']); ?>

            <a href="<?= '/statics/uploads/photos/' . $photo['src'] ?>" data-fancybox="gallery1" class="zoompic zoompic-dark">

                <?php if(file_exists($src)): ?>
                    <?php $file = Thumbnail::thumbnailFileUrl(
                        $src,
                        455,
                        260,
                        Thumbnail::THUMBNAIL_OUTBOUND,
                        false
                    ); ?>
                	<img src="/statics/images/picplaceholder.jpg" data-lazy="<?= $file?>">
                <?php endif;?>
            </a>
	</div>
	<?php endforeach;?>
</div>