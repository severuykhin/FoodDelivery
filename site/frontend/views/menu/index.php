<?php

use yii\helpers\VarDumper;
use frontend\widgets\Links;

$isRoot = $slug === 'all'; 
$title = $isRoot ? 'Доставка еды в Кирове. Заказать еду на дом' : $categories[0]->seo_page_title;
$desc = $isRoot ? 'Заказать вкусную еду с бесплатной доставкой по г. Киров. Быстрая доставка, онлайн заказ, скидки именникам и студентам.' : $categories[0]->seo_desc;
$h1 = $isRoot ? 'Доставка еды в Кирове' : $categories[0]->seo_title;


$this->title = $title;
$this->registerMetaTag([
	'name'    => 'description',
	'content' => $desc
]);

?>
<div class="content__block-s">
        <div class="container-fluide">
          <div class="store__info">
            <div class="store__info-item"><b>Минимальная сумма заказа - 450 руб.</b></div>
            <div class="store__info-item">Режим работы - ежедневно <b>10:00 - 22:00 <br> в пределах города</b></div>
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
									<h1 class="title_category"><?= $h1 ?></h1>
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
								'categorySlug'  => $category->slug,
								'categoryId'    => $category->id
	                		]);?>

	                	<?php endforeach;?>
	                </div>
	              </div>
            	<?php endforeach; ?>
            </div>
          </div>
        </div>
</div>

<?php if(false === $isRoot): ?>
<br>
<div class="container-fluide" style="display: flex;">
<div class="text" style="max-width: 600px;">
	<?= $categories[0]->description ?>
</div>
</div>
<br>
<br>
<?php endif; ?>