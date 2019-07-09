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

    public function countTotal()
    {
        $data = $this->compile();
        $res = 0;

        foreach($data as $index => $item)
        {
            $res += (int)$item['price'] * (int)$item['quantity'];
        }

        return $res;
    }

    public static function getOrdersSummary()
    {
        $orders = self::find();

        $total = 0;
        $biggestTotal = 0;
        $biggestOrder = [
            'details' => null,
            'data' => null
        ];

        foreach($orders->each() as $index => $order)
        {

            if ($order['name'] == 'test') continue;

            $orderData = $order->compile();
            $orderTotal = 0;

            foreach($orderData as $i => $item)
            {
                $orderTotal += (int)$item['price'] * (int)$item['quantity'];
            }

            $total += $orderTotal;
            if ($biggestTotal < $orderTotal)
            {
                $biggestTotal = $orderTotal;
                $biggestOrder = [
                    'details' => $order,
                    'data' => $orderData
                ];
            }
        }

        $count = (int)$orders->count();

        return [
            'ordersCount' => $count,
            'avg' => floor($total / $count),
            'perDay' => self::countAverageAmountPerDay($count),
            'totalSumm' => $total,
            'biggest' => [
                'summ' => $biggestTotal,
                'order' => $biggestOrder
            ]
        ];
    }

    public static function countAverageAmountPerDay($count = null)
    {
        if (!$count) 
        {
            $count = self::find()->count();
        }

        $firstOrder = self::findBySql("SELECT MIN(created_at) from cart_order WHERE name <> 'test'")->scalar();
        $lastOrder = self::findBySql("SELECT MAX(created_at) from cart_order WHERE name <> 'test'")->scalar();

        $days = floor(($lastOrder - $firstOrder) / 86400);
        $perDay = $count / $days;

        return number_format((float)$perDay, 1, '.', '');
    }


    public function getCustomerSummary()
    {
        $ordersQuery = self::find();
        $ordersCountByPhone = self::findBySql("SELECT `phone`, COUNT(id) as `total_count`, `name` from `cart_order` WHERE `name` <> 'test' GROUP BY `phone` ORDER BY `total_count` DESC")->asArray()->all();
        
        foreach($ordersCountByPhone as $index => $customer)
        {
            $orders = self::find()->where(['phone' => $customer['phone']])->all();

            foreach($orders as $order)  
            {
                $ordersCountByPhone[$index]['name'] = $order->name;
                $ordersCountByPhone[$index]['orders'][] = $order;
                $ordersCountByPhone[$index]['count'][] = [
                    'order_id' => $order->id,
                    'order_total' => $order->countTotal()
                ];
            }
        }

        return $ordersCountByPhone;
    }

    public function getDishSummary()
    {
        $data = self::findBySql("SELECT `cart_order_item`.`product_id`, `cart_order_item`.`modification_id`, COUNT(`cart_order_item`.`quantity`) as `quantity`, `dish`.`title`, `dish_modification`.`value` as `modification_name` 
                    from `cart_order_item` 
                        LEFT JOIN `dish` on `dish`.`id`=`cart_order_item`.`product_id` 
                        LEFT JOIN `dish_modification` on `dish_modification`.`id`=`cart_order_item`.`modification_id` 
                        LEFT JOIN `cart_order` on `cart_order_item`.`order_id`=`cart_order`.`id`
                            WHERE `cart_order`.`name` <> 'test'
                            GROUP BY `product_id`, `modification_id` ORDER BY `quantity` DESC")->asArray()->all();
        return $data;
    }
}