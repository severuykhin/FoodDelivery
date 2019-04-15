<?php

namespace common\models;

use Yii;
use common\models\CartOrderItem;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cart_order".
 *
 * @property int $id
 * @property int $cart_id
 * @property string $phone
 * @property string $email
 * @property int $payment
 * @property string $street
 * @property string $house
 * @property string $code
 * @property string $apartment
 * @property string $floor
 * @property string $entrance
 * @property string $comment
 */
class CartOrder extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_VIEWED = 1;

    const PAYMENT_CASH = 0;
    const PAYMENT_CARD = 1;

    public $items = [];
    public $details;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cart_id', 'payment', 'updated_at', 'created_at', 'status'], 'integer'],
            [['name', 'phone', 'street', 'house'], 'required'],
            [['phone', 'email', 'street', 'house', 'code', 'apartment', 'floor', 'entrance', 'comment', 'name', 'change'], 'string', 'max' => 255],
            [['phone', 'email', 'street', 'house', 'code', 'apartment', 'floor', 'entrance', 'comment', 'name', 'payment'], 'filter','filter'=>'yii\helpers\BaseHtml::encode']
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_NEW => 'Новый',
            self::STATUS_VIEWED => 'Принят'
        ];
    }

    public function getStatus()
    {
        return self::getStatuses()[$this->status];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cart_id' => 'Cart ID',
            'name' => 'Ваше имя',
            'phone' => 'Ваш телефон',
            'email' => 'Ваш email',
            'payment' => 'Способ оплаты',
            'street' => 'Улица',
            'house' => 'Дом',
            'items' => 'Позиции заказа',
            'code' => 'Код подъезда',
            'apartment' => 'Квартира',
            'floor' => 'Этаж',
            'status' => 'Статус заказа',
            'entrance' => 'Подъезд',
            'comment' => 'Комментарий к заказу',
            'change' => 'С какой суммы подготовить сдачу',
            'updated_at' => 'Дата создания',
            'created_at' => 'Дата обновления',
            'details' => 'Подробности'
        ];
    }

    public function process($cart)
    {
        if (!$cart) 
        {
            throw new Exception('No CART instance!');
        }
        $items = $cart->getItems()->all();

        foreach($items as $cartItem) 
        {
            $orderItem = new CartOrderItem();
            $orderItem->cart_id = $cart->id;
            $orderItem->order_id = $this->id;
            $orderItem->product_id = $cartItem->product_id;
            $orderItem->modification_id = $cartItem->modification_id;
            $orderItem->quantity = $cartItem->quantity;

            $orderItem->save();
            $cartItem->delete();
        }
    }

    public function compile() 
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
                    'size' => $value,
                    'weight' => $weight,
                    'quantity' => $item->quantity
                ];

            }
        }

        return $data;
    }

    public function send($data)
    {
        foreach (Yii::$app->params['emails'] as $email) 
        {
            Yii::$app->mailer->compose('order', [
                'model' => $this,
                'data'  => $data
                ])
                ->setFrom([Yii::$app->params['supportEmail'] => 'shymovka43.ru'])
                ->setTo($email)
                ->setSubject('Заявка на доставку shymovka43.ru')
                ->send();
        }
    }

    public static function paymentTypes()
    {
        return [
            0 => 'Наличными курьеру',
            1 => 'По карте курьеру'
        ];
    }

    public function getPaymentType()
    {
        return self::paymentTypes()[$this->payment];
    }

    public function getOrderTime()
    {
        return date('d-m-Y H:i:s', $this->created_at);
    }

    public function getItems()
    {
        return $this->hasMany(CartOrderItem::class, ['order_id' => 'id']);
    }
}
