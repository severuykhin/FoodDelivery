<?php

use yii\helpers\Html;

?>

<?=  $this->render('_actions', [
  'actionDishes' => $actionDishes
]); ?>


<div class="best">
      <div class="best__title">
        <h2>Любимые блюда наших гостей</h2>
      </div>
      <div class="container">
        <div class="best__inner">
          <?php  for ($i = 0; $i < 6; $i++) {  ?>
            <div class="best__item">
              <div class="dish">
                <div class="dish__image"><img src="/statics/images/dish.jpg"></div>
                <div class="dish__info">
                  <div class="dish__title">Пивная тарелка</div>
                  <div class="dish__weight">300 г</div>
                  <div class="dish__text">Классическая пивная тарелка с картофелем, сыром и копченостями прекрасно подойдет к пенному напитку</div>
                </div>
                <div class="dish__order">
                  <div data-role="dish-order" class="button button__primary">Хочу</div>
                  <div class="dish__price">350 руб
                    <div class="dish__old">450 руб</div>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>

    <div class="buttons__container buttons__container-center"><a class="button button__primary button__primary-big" href="#">Смотреть меню</a></div>
  </div>
</div>

<div class="content__block">
    <div class="container">
        <div class="reviews">
            <div class="reviews__title">
                <h2>Отзывы наших гостей</h2>
            </div>

            <?= $this->render('_reviews', [
                'reviews' => $reviews
            ]);?>

            <div class="reviews__button">
              <?= Html::a('Смотреть все отзывы', ['/reviews'], [
                'title' => 'Смотреть отзывы о работе Кафе «Шумовка»',
                'class' => 'reviews__watch'
              ]);?>
            </div>

        </div>
    </div>
</div>
<div class="content__block">
  <?= $this->render('_about', [
    'aboutPhotos' => $aboutPhotos
  ]); ?>
</div>