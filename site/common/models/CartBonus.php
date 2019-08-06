<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cart_bonus".
 *
 * @property int $id
 * @property int $cart_id
 * @property int $product_id
 * @property int $modification_id
 */
class CartBonus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart_bonus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cart_id', 'product_id', 'modification_id'], 'integer'],
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
        ];
    }

}
