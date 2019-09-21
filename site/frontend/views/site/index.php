<?php

use yii\helpers\Html;
use frontend\widgets\SeoActiveLinks;

$this->title = 'Доставка еды на дом в Кирове';

$this->registerMetaTag([
  'name'    => 'description',
  'content' => 'Закажите вкусную еду на дом или в офис. Бесплатная и быстрая доставка, удобный онлайн заказ, скидки именинникам и студентам'
]);

?>

<div class="site__index-img">
  <img src="/statics/images/index-img.jpg" alt="Акция - при заказе от 950 руб. - Пицца 40см в подарок!">
</div>
<br>
<div class="container-fluide">*Акция не суммируется с другими акциями и скидками кафе</div>

<!-- Блок Любимые блюда -->
<?= $this->render('_best', [
  'bestDishes' => $bestDishes
]);?>
<!-- Блок Любимые блюда END -->

<!-- Блок с фото -->
<?= $this->render('_photoblock', [
  'photos' => array_slice($aboutPhotos, 0, 4)
]);?>
<!-- Блок с фото END -->

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