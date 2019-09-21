<?php

use aquy\thumbnail\Thumbnail;
use yii\helpers\Html;

?>

<div class="store__item">
	<?= $this->render('_card', [
		'item' => $item,
		'categoryTitle' => $categoryTitle,
		'categorySlug'  => $categorySlug,
		'categoryId'    => $categoryId,
		'index' => $index
]) ?>
</div>