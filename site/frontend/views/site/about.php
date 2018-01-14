<?php use aquy\thumbnail\Thumbnail; ?>

<div class="content__block">
        <div class="container">
          <div class="content__block-title">
            <h1>Немного о нас</h1>
          </div>
          <div class="photo" data-lazyload="true">
    
            <?php $count = 0; ?>
            <?php foreach($about as $item):?>
                <?php if($count % 2 === 0):?>
                <div class="photo__row">
                    <div class="photo__desc"> 
                        <h4 data-num="<?= $count + 1 ?>"><?= $item->title ?></h4>
                        <p><?= $item->desc ?></p>
                    </div>
                    <div class="photo__image">
                    <?php if(file_exists(Yii::getAlias('@statics/uploads/photos/'. $item->src))): ?>
                        <a href="<?= '/statics/uploads/photos/' . $item->src ?>" data-fancybox="gallery1" class="zoompic zoompic-dark">
                            <?php $thumb = Thumbnail::thumbnailFileUrl(
                                Yii::getAlias('@statics/uploads/photos/'. $item->src),
                                600,
                                300,
                                Thumbnail::THUMBNAIL_OUTBOUND,
                                false
                            ); ?>
                            <img alt="Кафе Шумовка Киров" src="<?= $thumb ?>">
                        </a>
                    <?php else:?>
                    <img src="/statics/images/dishplaceholder.png">
                    <?php endif;?>
                    </div>
                </div>
                <?php else:?>
                <div class="photo__row">
                    <div class="photo__image">
                    <?php if(file_exists(Yii::getAlias('@statics/uploads/photos/'. $item->src))): ?>
                        <a href="<?= '/statics/uploads/photos/' . $item->src ?>" data-fancybox="gallery1" class="zoompic zoompic-dark">
                            <?php $thumb = Thumbnail::thumbnailFileUrl(
                                Yii::getAlias('@statics/uploads/photos/'. $item->src),
                                600,
                                300,
                                Thumbnail::THUMBNAIL_OUTBOUND,
                                false
                            ); ?>
                            <img alt="Кафе Шумовка Киров" src="/statics/images/dishplaceholder.png" data-lazy="<?= $thumb ?>">
                        </a>
                    <?php else:?>
                    <img src="/statics/images/dishplaceholder.png">
                    <?php endif;?>
                    </div>
                    <div class="photo__desc">
                        <h4 data-num="<?= $count + 1 ?>"><?= $item->title ?></h4>
                        <p><?= $item->desc ?></p>
                    </div>
                </div>
                <?php endif;?>
                <?php $count++;?>
            <?php endforeach;?>
          </div>
        </div>
      </div>
      <div class="content__block content__block-woodback">
        <?= $this->render('_feed', [
            'feed' => $feed
        ]);?>
      </div>