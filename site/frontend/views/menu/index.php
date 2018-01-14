<?php

use yii\helpers\VarDumper;
$this->title = 'Меню - Кафе шумовка Киров';
$this->registerMetaTag([
	'name'    => 'description',
	'content' => 'Кафе Шумовка - доставка домашней еды, доставка пиццы, доставка роллов в Кирове' 
]);

$this->registerMetaTag([
	'name'    => 'keywords',
	'content' => 'Доставка еды Киров, роллы, пицца, доставка, кафе киров, домашня еда'
]);

?>
<div class="content__block-s">
        <div class="container-fluide">
          <div class="store__info">
            <div class="store__info-item">Чтобы сделать заказ позвоните по телефону:<br><a href="tel:+78332416646"> <b>41-66-46</b></a></div>
            <div class="store__info-item">Бесплатная доставка при сумме заказа от <b>450 Р</b></div>
            <div class="store__info-item">Режим работы - ежедневно <b>10:00 - 22:00 в пределах города</b></div>
            <div class="store__info-item">Время доставки уточнит менеджер при заказе</div>
          </div>
        </div>
      </div>
<div class="content__block">
        <div class="container-fluide">
          <div class="store" data-role="store">
            <div class="filter">
              <div class="filter__inner">
              	<a class="filter__item" href="#all" data-role="filter-button"> 
              		<span>Все</span>
              	</a>

              	<?php foreach($categories as $category): ?>
	              	<a class="filter__item" href="#<?= $category->slug ?>" data-role="filter-button"> 
	              		<span>
	              			<?php
	              				if ($category->id == 5) {
	              					echo 'Пельмешки';
	              				} else if ($category->id == 9) {
	              					echo 'Лапша';
	              				} else {
	              					echo $category->title;
	              				}
	              			?>
	              		</span>
	              	</a>
              	<?php endforeach;?>

              	</div>
            </div>
            <div class="store__inner">

            	<?php foreach($categories as $category):?>
	            <div class="store__block" data-role="store-category" data-route="<?= $category->slug?>">
	                <div class="store__category">
	                  <h3><?= $category->title ?></h3>
	                </div>
	                <div class="store__items">
	                	<?php foreach($category->dishes as $item):?>

	                		<?= $this->render('_item', [
	                			'item'          => $item,
	                			'categoryTitle' => $category->title,
	                			'categorySlug'  => $category->slug
	                		]);?>

	                	<?php endforeach;?>
	                </div>
	              </div>
            	<?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>