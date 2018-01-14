<?php

use aquy\thumbnail\Thumbnail;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="content__block content__block-padding-top">
  <div class="container-fluide">
    <div class="actions">
      <div class="actions__inner" data-role="slider">
        <?php foreach($banners as $banner): ?>
            <div class="actions__item">

                <?php if(!empty($banner['url'])): ?>
                    <a href="<?= Url::to(['/' . $banner['url']]); ?>">
                <?php endif;?>

                <img src="<?= '/statics/uploads/photos/' . $banner['src'] ?>" alt="<?= !empty($banner['title']) ? $banner['title'] : 'Кафе Шумовка - доставка еды в Кирове' ?>">

                <?php if(!empty($banner['url'])): ?>
                    </a>
                <?php endif;?>

            </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>