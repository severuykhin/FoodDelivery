<?php use aquy\thumbnail\Thumbnail; ?>


<div class="feed">
    <div class="feed__title">
        <h2>Фотолента</h2>
    </div>
    <div class="feed__content">
        <?php $itemsCount = 1;?>
        <?php foreach($feed as $item): ?>
            <?php if ($itemsCount % 2 !== 0 || $itemsCount === 0):?>
                <div class="feed__row">
            <?php endif;?>

            <div class="feed__item">
                <div class="feed__img">
                    <?php if(file_exists(Yii::getAlias('@statics/uploads/photos/'. $item->src))): ?>
                        <a href="<?= '/statics/uploads/photos/' . $item->src ?>" data-fancybox="gallery2" class="zoompic zoompic-dark">
                            <?php $thumb = Thumbnail::thumbnailFileUrl(
                                Yii::getAlias('@statics/uploads/photos/'. $item->src),
                                400,
                                300,
                                Thumbnail::THUMBNAIL_OUTBOUND,
                                false
                            ); ?>
                            <img alt="<?= $item->title?> - Кафе Шумовка Киров" src="/statics/images/dishplaceholder.png" data-lazy="<?= $thumb ?>">
                        </a>
                    <?php else:?>
                    <img src="/statics/images/dishplaceholder.png">
                    <?php endif;?>
                </div>
                <div class="feed__desc"><?= $item->desc?>
                  <div class="feed__data"><?= date('d.m.Y', $item->date) ?></div>
                </div>
            </div>

            <?php if($itemsCount % 2 == 0):?>
                </div>
            <?php endif;?>
        <?php $itemsCount++; ?>
        <?php endforeach;?>
    </div>
</div>