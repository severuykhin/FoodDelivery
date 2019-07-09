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
            <br><br>
          <div class="about__content">
            <div class="about__subtitle"> 
              <h1>«Шумовка» - доставка вкусной, домашней еды в Кирове</h1>
            </div>
            <div class="about__text">
              <p>
                Закажите вкусную еду на дом или в офис. Бесплатная и быстрая доставка по г. Киров с 10:00 до 22:00, удобный онлайн заказ на сайте. 
              </p>
              <p>
                В нашем меню вы найдете не только пиццу и роллы, но и разнообразные горячие блюда, готовые обеды, азиатскую кухню и детское меню. 
              </p>
              </div>
            <div class="about__buttons">
                <?= Html::a('Наша фотолента', ['/about'], ['class' => 'button-secondary button-secondary-about']);?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>