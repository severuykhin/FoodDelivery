<?php

use yii\helpers\VarDumper;
use frontend\widgets\Links;

$isRoot = Yii::$app->request->get('slug') === 'all'; 
$title = $isRoot ? 'Доставка еды в Кирове' : $categories[0]->seo_title;

$this->title = $title . ' | Кафе Шумовка';
$this->registerMetaTag([
	'name'    => 'description',
	'content' => 'Кафе Шумовка - ' . $title 
]);

$this->registerMetaTag([
	'name'    => 'keywords',
	'content' => 'Доставка еды Киров, роллы, пицца, доставка, кафе киров, домашня еда'
]);

?>
<div class="content__block-s">
        <div class="container-fluide">
					<h1 class="menu__title">Шумовка - доставка вкусной, домашней еды в Кирове</h1>
          <div class="store__info">
            <div class="store__info-item"><b>Минимальная сумма заказа - 450 руб.</b></div>
            <div class="store__info-item">Режим работы - ежедневно <b>10:00 - 22:00 в пределах города</b></div>
            <div class="store__info-item">Время доставки уточнит менеджер <br> при заказе</div>
          </div>
        </div>
      </div>
<div class="content__block">
        <div class="container-fluide">
          <div class="store" data-role="store">
						<?= Links::widget() ?>
            <div class="store__inner">
								<div class="store__category">
									<h1 class="title_category"><?= $title ?></h1>
								</div>
            	<?php foreach($categories as $category):?>
							<div class="store__block" data-role="store-category" data-route="<?= $category->slug?>">
									<?php if($isRoot): ?>
										<h3 style="padding-top: 30px;"><?= $category->title ?></h3>	
									<?php endif; ?>
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