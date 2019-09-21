<?php

use yii\helpers\Url;

?>

<br>
<div class="container-fluide">
    <div class="filter">
        <div class="filter__inner">
            <?php

            foreach($links as $link): ?>
                <?php if(Yii::$app->request->get('slug') === $link['slug']): ?>

                    <span class="filter__item filter__item-active">
                    <span>
                        <?= $link['name'] ?>
                    </span>
                </span>

                <?php else: ?>
                    <a class="filter__item" href="<?= Url::to(['menu/category', 'slug' => $link['slug']]); ?>">
                    <span>
                        <?= $link['name'] ?>
                    </span>
                    </a>
                <?php endif; ?>
            <?php endforeach;?>

        </div>
    </div>
</div>
<br>