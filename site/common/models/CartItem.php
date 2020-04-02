<?php

namespace common\models;

use Yii;
use common\models\Dish;
use common\models\DishModification;

/**
 * This is the model class for table "cart_item".
 *
 * @property int $id
 * @property int $cart_id
 * @property int $product_id
 * @property int $modification_id
 * @property int $quantity
 */
class CartItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cart_id', 'product_id', 'modification_id', 'quantity'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cart_id' => 'Cart ID',
            'product_id' => 'Product ID',
            'modification_id' => 'Modification ID',
            'quantity' => 'Quantity',
        ];
    }

    public function getProduct()
    {
        return Dish::find()->where(['id' => $this->product_id])->with(['category']);
    }

    public function getProductWithModification()
    {
        $query = Dish::findBySql('SELECT 
            dish.title, 
            dish.id, 
            dish.pic,
            dish.category_id, 
            dish.act_in_action,
            dish_modification.id as mId, 
            dish_modification.price as price, 
            dish_modification.weight as weight, 
            dish_modification.value,
            category.slug as category_slug,
            category.title as category_title 
            FROM dish 
            LEFT JOIN dish_modification on dish.id = dish_modification.dish_id
            LEFT JOIN categories as category on dish.category_id = category.id
            WHERE dish.id = :did AND dish_modification.id = :mid', 
        [':did' => $this->product_id, ':mid' => $this->modification_id]);
        $query->multiple = true;
        return $query;
    }

    public function existingModifications()
    {
        return DishModification::find()->where(['dish_id' => $this->product_id]);
    }
}
