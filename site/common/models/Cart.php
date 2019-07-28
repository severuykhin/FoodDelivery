<?php

namespace common\models;

use Yii;
use common\models\CartItem;
use yii\helpers\VarDumper;
use aquy\thumbnail\Thumbnail;

/**
 * This is the model class for table "cart".
 *
 * @property int $id
 * @property string $session_id
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['session_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'session_id' => 'Session ID',
        ];
    }

    public function getItems()
    {
        return $this->hasMany(CartItem::class, ['cart_id' => 'id']);
    }

    public function add(array $item)
    {
        $cartItemQuery = CartItem::find()
                        ->where(['cart_id' => $this->id])
                        ->andwhere(['product_id' => $item['product']]);

        if ($item['modification']) {
            $cartItemQuery->andwhere(['modification_id' => $item['modification']]);
        }
        $cartItem = $cartItemQuery->one();

        if ($cartItem) 
        {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            $cartItem = new CartItem();
            $cartItem->cart_id = $this->id;
            $cartItem->product_id = $item['product'];
            $cartItem->modification_id = $item['modification'];
            $cartItem->quantity = 1;
            $cartItem->save();
        }

        return $cartItem;
    }

    public function remove(array $item) 
    {
        $cartItemQuery = CartItem::find()
                        ->where(['cart_id' => $this->id])
                        ->andwhere(['product_id' => $item['product']]);

        if ($item['modification']) {
            $cartItemQuery->andwhere(['modification_id' => $item['modification']]);
        }
        $cartItem = $cartItemQuery->one();

        // Пару раз в логах была ошибка "Creating default object from empty value" на строке уменьшения 
        // Это значит, что по какой то причине в бд не обнаруживается $cartItem и туда приходит null
        if (!$cartItem) return 'deleted';
        
        $cartItem->quantity -= 1;

        if ($cartItem->quantity === 0) {
            $cartItem->delete();
            return 'deleted';
        } else {
            $cartItem->save();
            return $cartItem;
        }


    }

    public function deleteItem(array $item)
    {
        $cartItemQuery = CartItem::find()
                        ->where(['cart_id' => $this->id])
                        ->andwhere(['product_id' => $item['product']]);

        if ($item['modification']) {
            $cartItemQuery->andwhere(['modification_id' => $item['modification']]);
        }
        $cartItem = $cartItemQuery->one();

        if ($cartItem->delete()) return true;
        else return false;
    }

    public function getActualItems()
    {
        $items = $this->getItems()->all();
        $data = [];

        foreach($items as $index => $item)
        {
            if ($item->modification_id) {
                $product = $item->getProductWithModification()->asArray()->one();

                $data[] = [
                    'id' => $product['id'],
                    'title' => $product['title'],
                    'mId'  => $product['mId'],
                    'price' => $product['price'],
                    'pic' => $product['pic'],
                    'size' => $product['value'],
                    'weight' => $product['weight'],
                    'quantity' => $item->quantity
                ];                
            }

            // Если модификации были добавленны позже, чем продукт был положен в корзину
            // В этом случае берем первую модификацию
            else {
                $existingModifications = $item->existingModifications()->asArray()->all();
                $product = $item->getProduct()->asArray()->one();
                $mid; 
                $price; 
                $weight;
                $value = '';
                
                if ($existingModifications) {
                    $mid = $existingModifications[0]['id'];
                    $price = $existingModifications[0]['price'];
                    $weight = $existingModifications[0]['weight'];
                    $value = $existingModifications[0]['value'];

                    $item->modification_id = $existingModifications[0]['id'];
                    $item->save();
                } else {
                    $price = $product['price_actual'];
                    $mid = '';
                    $weight = $product['weight'];
                }

                $data[] = [
                    'id' => $product['id'],
                    'title' => $product['title'],
                    'mId'  => $mid,
                    'price' => $price,
                    'pic' => $product['pic'],
                    'size' => $value,
                    'weight' => $weight,
                    'quantity' => $item->quantity
                ];
            }
        }

        foreach($data as &$item)
        {
            $item['pic'] = Thumbnail::thumbnailFileUrl(
                Yii::getAlias('@statics/uploads/dishes/') . $item['id'] . '/' . $item['pic'],
                290,
                193,
                Thumbnail::THUMBNAIL_OUTBOUND 
            );
        }

        return $data;
    }
}
