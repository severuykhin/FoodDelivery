<?php 

use yii\helpers\Html;
use aquy\thumbnail\Thumbnail;

?>

<div class="about">
    <div class="about__info">
        <div class="about__info-inner">
            <div class="about__title">
                <h2>Немного о нас</h2>
            </div>
            <div class="about__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mollis posuere massa. Fusce interdum porttitor tempor. Proin sit amet massa lacus. Nam venenatis lorem ac nulla euismod, et rutrum erat aliquet. Aenean vel magna vestibulum ex volutpat tincidunt. Nunc interdum orci id mollis ultricies. Donec a est non sem varius condimentum ac eget dolor. Nulla lacinia nisi ante, vel dignissim nisl maximus non. Nulla facilisi. Vivamus rhoncus ultrices elit.</div>
            <div class="about__button">
                <?= Html::a('Читать дальше', ['/about'], ['class' => 'about__read']); ?>
            </div>
            <div class="about__socials"></div>
        </div>
    </div>
    <div class="about__images">
        <?php foreach($aboutPhotos as $photo):?>
        <?php $src = Yii::getAlias('@statics/uploads/photos/' . $photo->src); ?>
            <div class="about__image">
                <a href="<?= '/statics/uploads/photos/' . $photo->src ?>" data-fancybox class="zoompic zoompic-colored">

                    <?php if(file_exists($src)): ?>
                        <?= Thumbnail::thumbnailImg(
                            $src,
                            400,
                            400,
                            Thumbnail::THUMBNAIL_OUTBOUND,
                            [
                                'alt' => 'Шумовка - доставка вкусной еды в Кирове'
                            ]
                        ); ?>
                    <?php endif;?>

                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>