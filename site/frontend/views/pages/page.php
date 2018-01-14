<?php 

use yii\helpers\Html;

$this->registerMetaTag([
    'name'    => 'description',
    'content' => $page->title
]);

?>


<div class="container">

	<div class="content__block-title">
	    <h1><?= $page->title ?></h1>
	</div>
	<article class="article">
	    <?= $page->content ?>
	</article>
	<div class="content__block centered">
		<?= Html::a('Смотреть меню', ['/menu#all'], ['class' => 'button-secondary button-secondary-about'])?>
		<?= Html::a('Наша фотолента', ['/about'], ['class' => 'button-secondary button-secondary-about button-secondary-about-hovered '])?>
	</div>

</div>