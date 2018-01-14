<?php 

use yii\helpers\Html;
use aquy\thumbnail\Thumbnail;

?>
<div class="content__block content__block-l">
  <div class="container-fluide">
    <div class="about">
      <div class="about__info">
        <div class="about__image">
            <div class="about__image-inner">
                <?php $src = Yii::getAlias('@statics/images/about1.jpg'); ?>

                    <a href="<?= '/statics/images/about1.jpg' ?>" data-fancybox class="zoompic zoompic-dark">

                        <?php if(file_exists($src)): ?>
                            <?= Thumbnail::thumbnailImg(
                                $src,
                                600,
                                400,
                                Thumbnail::THUMBNAIL_OUTBOUND,
                                [
                                    'alt' => 'Шумовка - доставка вкусной еды в Кирове'
                                ]
                            ); ?>
                        <?php endif;?>

                    </a>
            </div>
        </div>
        <div class="about__info-inner">
          <div class="about__title">Немного о нас</div>
          <div class="about__content">
            <div class="about__subtitle"> 
              <h2>«Шумовка» - это свежая еда <br> и прекрасный сервис</h2>
            </div>
            <div class="about__text">Integer a dolor eu eros sodales posuere. Nam tempus lacus pulvinar purus faucibus ultricies sed ac dolor. Aenean vitae sapien eget risus posuere cursus. Donec accumsan erat erat, vel fermentum lectus iaculis ut.</div>
            <div class="about__buttons">
                <?= Html::a('Наша фотолента', ['/about'], ['class' => 'button-secondary button-secondary-about']);?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>