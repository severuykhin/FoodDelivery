<?php  

use aquy\thumbnail\Thumbnail;
use yii\helpers\Html;
use yii\helpers\Json;

?>

<div class="dish dish_sous" data-role="product">
    <div class="dish_sous-wrap">
        <div class="dish__info">
            <div class="dish__title"><?= $item->title ?></div>
        </div>
    </div>

    <div class="dish__order">
        <?php 
            $price = $item->modifications ? $item->modifications[0]->price : $item->price_actual; 
            $price_old = $item->modifications ? $item->modifications[0]->price_old : $item->price_old; 
        ?>
        <div class="dish__price">
            <span data-role="product-price"></span> <span style="opacity: 0;">₽</span>
            <?php if (!empty($price_old)): ?>
                <div class="dish__old"><span style="opacity: 0;">₽</span></div>
            <?php endif;?>
        </div>

        <?php  

            $pData = [
                'id' => $item->id,
                'mId' => $item->modifications ? $item->modifications[0]->id : '',
                'title'=> $item->title,
                'price' => $item->modifications ? Yii::$app->formatter->asDecimal($item->modifications[0]->price, 0) : Yii::$app->formatter->asDecimal($item->price_actual, 0),
                'weight'=> $item->modifications ? $item->modifications[0]->weight : '',
                'size' => $item->modifications ? $item->modifications[0]->value : '',
                'category_id' => 20
            ];
        
        ?>
            
        <div class="dish__actions">
            <div class="dish__regulator" data-role="dish-regulator">
                <button  class="button button_regulator button_minus"
                    data-type="add-minus"
                    data-product='<?= JSON::encode($pData) ?>' 
                    data-role="product-remove">-
                </button>
                <span 
                    class="dish__amount"
                    data-role="dish-amount">0</span>
                <button class="button button_regulator button_plus"
                    data-type="add-plus"
                    data-product='<?= JSON::encode($pData) ?>'
                    data-role="product-add">+
                </button>
            </div>
            <button 
                data-id="<?= $item->id ?>"
                data-productid="<?= $item->id ?>"
                class="button button__primary"
                data-product='<?= JSON::encode($pData) ?>'
                data-type="add-init"
                data-role="product-add">В корзину
            </button>   
        </div>
    </div>
</div>