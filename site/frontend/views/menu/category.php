<?php  

use frontend\widgets\Dishes;

$this->registerMetaTag([
	'name'    => 'description',
	'content' => 'Кафе Шумовка - доставка домашней еды, доставка пиццы, доставка роллов в Кирове' 
]);

$this->registerMetaTag([
	'name'    => 'keywords',
	'content' => 'Доставка еды Киров, роллы, пицца, доставка, кафе киров, домашня еда' . $category->title
]);

$this->title = 'Кафе шумовка - ' . $category->title;

?>

<div class="container">
    <div class="content__title-h1">
        <h1> <?= $category->title ?> </h1>
    </div>
    <div class="store__block" data-role="store">
	    <div class="store__items">
	    	<?php foreach($dishes as $item):?>

	    		<?= $this->render('_item', [
	    			'item'     => $item,
	    			'category' => $category->title
	    		]);?>

	    	<?php endforeach;?>
	    </div>
	 </div>

    <div class="content__description">
        <?= $category->description?>
    </div>
</div>