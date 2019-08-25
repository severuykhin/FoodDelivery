<?php

namespace backend\actions\customers;

use Yii;
use common\models\CartOrder;

class CustomersReport extends \yii\base\Action
{
    public static function run()
    {
        $ordersByPhone = CartOrder::findBySql(
            "SELECT MAX(`phone`) as `phone`, COUNT(id) as `total_count`, MAX(`name`) as `name` 
                from `cart_order` 
                WHERE `name` <> 'test' 
                AND `status` = 1 
                GROUP BY `phone` 
                ORDER BY `total_count` DESC")->asArray()->all();
        
        foreach($ordersByPhone as $index => $customer)
        {
            $orders = CartOrder::find()
                        ->where(['phone' => $customer['phone']])
                        ->orderBy(['created_at' => SORT_ASC])
                        ->all();

            foreach($orders as $order)  
            {
                $ordersByPhone[$index]['name'] = $order->name;
                $ordersByPhone[$index]['orders'][] = $order;
                $ordersByPhone[$index]['count'][] = [
                    'order_id' => $order->id,
                    'order_total' => $order->countTotal()
                ];
            }
        }

        return $ordersByPhone;
    }
}
