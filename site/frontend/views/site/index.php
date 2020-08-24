<?php

use yii\helpers\Html;
use frontend\widgets\SeoActiveLinks;

$this->title = 'Доставка еды на дом в Кирове';

$this->registerMetaTag([
  'name'    => 'description',
  'content' => 'Закажите вкусную еду на дом или в офис. Бесплатная и быстрая доставка, удобный онлайн заказ, скидки именинникам и студентам'
]);

?>

<style>

.site__index-img {
  height: 550px;
  opacity: 0;
}

.slick-slide {
  opacity: 1;
}

.main-slider-item-1 {
  background: url('/statics/images/shum_kombo1.jpg');
  background-size: cover;
  background-position: center center;
}

.main-slider-item-2 {
  background: url('/statics/images/shum_kombo2.jpg');
  background-position: center center;
  background-size: cover;
}

.main-slider-item-3 {
  background: url('/statics/images/shum_kombo3.jpg');
  background-position: center center;
  background-size: cover;
}

.main-slider-item-4 {
  background: url('/statics/images/index-img.jpg');
  background-position: center center;
  background-size: cover;
}

#main-slider {
  position: relative;
}

#main-slider .slick-arrow {
  position: absolute;
  height: 100%;
  width: 70px;
  top: 0;
  z-index: 2;
  font-size: 0;
  border: none;
  background: transparent;
  cursor: pointer;
  overflow: hidden;
}

#main-slider .slick-arrow::before {
  position: absolute;
  content: '';
  top: 50%;
  left: 50%;
  margin-left: -12px;
  margin-top: -12px;
  width: 24px;
  height: 24px;
  border-left: 3px solid #88bd4b;
  border-bottom: 3px solid #88bd4b;
}

#main-slider .slick-arrow:hover {
  background: rgba(0,0,0, .1);
}

#main-slider .slick-arrow:focus {
  outline: none;
}

#main-slider .slick-prev {
  left: 0;
}

#main-slider .slick-prev::before {
  transform: rotate(45deg);
}

#main-slider .slick-next::before {
  transform: rotate(-135deg);
}


#main-slider .slick-next {
  right: 0;
}

@media(max-width: 1140px) {
  .site__index-img {
    height: 300px;
  } 
}

@media(max-width: 560px) {
  .site__index-img {
    height: 250px;
  } 
}


</style>

<div id="main-slider">
  <div class="main-slider-item main-slider-item-1 site__index-img">
    <!-- <img src="/statics/images/shum_kombo1.jpg" alt="Комбо-набор Вечерний"> -->
  </div>
  <div class="main-slider-item main-slider-item-2 site__index-img">
    <!-- <img src="/statics/images/shum_kombo2.jpg" alt="Комбо-набор Студенческий"> -->
  </div>
  <div class="main-slider-item main-slider-item-3 site__index-img">
    <!-- <img src="/statics/images/shum_kombo1.jpg" alt="Комбо-набор Детский"> -->
  </div>
</div>

<br>
<div class="container-fluide">*Акции не суммируются с другими акциями, комбо-наборами, сертификатами и скидками кафе</div>

<?= \frontend\widgets\MainGoods::widget() ?>

<!-- Блок о нас -->
<?= $this->render('_about'); ?>
<!-- Блок о нас END -->

<!-- Блок с фото -->
<?= $this->render('_photoblock', [
  'photos' => array_slice($aboutPhotos, 5, 9)
]);?>
<!-- Блок с фото END -->


<div class="content__block">
    <div class="container">
        <div class="reviews reviews-index">
            <div class="reviews__title">
                <h2><span>Отзывы наших гостей</span>  
                  <?= Html::a('Смотреть все отзывы', ['site/reviews'], ['class' => 'button-secondary']); ?> 
                </h2>
            </div>
            <div class="reviews__inner">
              <?= $this->render('_reviews', [
                  'reviews' => $reviews
              ]);?>
            </div>
        </div>
    </div>
</div>

<?= SeoActiveLinks::widget() ?>

<?php

$script = <<< JS
    $('#main-slider').slick({
        autoplay: true,
        autoplaySpeed: 4000
    });
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_LOAD);

?>