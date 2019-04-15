<?php

use yii\helpers\Html;

$this->title = 'Доставка еды в Кирове | Шумовка';

$this->registerMetaTag([
  'name'    => 'description',
  'content' => 'Кафе Шумовка - доставка домашней еды, доставка пиццы, доставка роллов в Кирове' 
]);

// $this->registerMetaTag([
//   'name'    => 'keywords',
//   'content' => 'Доставка еды Киров, роллы, пицца, доставка, кафе киров, домашня еда'
// ]);

?>

<!-- Actions -->
<!-- <?= $this->render('_actions', [
  'banners' => $banners
]);?> -->
<!-- Actions end -->

<!-- Advantages -->
<?= $this->render('_adv');?>
<!-- Advantages end -->

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