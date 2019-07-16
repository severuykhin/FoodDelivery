<?php

use yii\helpers\Url;

?>

<div class="filter hidden-md-down">
    <div class="filter__inner">

    <?php foreach($categories as $category): ?>
        <?php if(Yii::$app->request->get('slug') === $category['slug']): ?>

            <span class="filter__item filter__item-active"> 
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
            </span>

        <?php else: ?>
            <a class="filter__item" href="<?= Url::to(['menu/category', 'slug' => $category['slug']]); ?>"> 
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
        <?php endif; ?>
    <?php endforeach;?>

    </div>
</div>