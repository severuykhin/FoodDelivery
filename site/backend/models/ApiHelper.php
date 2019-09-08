<?php

namespace backend\models;

use Yii;
use common\models\CartOrder;
use common\models\CartOrderItem;
use common\models\Report;
use common\models\Dish;
use common\models\Category;

class ApiHelper 
{
    public static function getOrdersSummary(array $data): array
    {
        $query = CartOrder::find();
        
        $range = self::getRangeInfo($data);

        $query->where(['status' => CartOrder::STATUS_VIEWED]);
        $query->andWhere(['>=', 'created_at', $range['startTimestamp']]);
        $query->andWhere(['<=', 'created_at', $range['endTimestamp']]);

        $reports = Report::find()
                    ->where(['>=', 'created_at', $range['startTimestamp']])
                    ->andWhere(['<=', 'created_at', $range['endTimestamp']])
                    ->all();

        $total = 0;
        $biggestTotal = 0;
        $biggestOrder = [
            'details' => [],
            'data' => []
        ];

        foreach($query->each() as $index => $order)
        {
            /** @var CartOrder $order */

            if ($order['name'] == 'test' || $order['status'] != CartOrder::STATUS_VIEWED) continue;

            $orderData = $order->compile();
            $freeSousAmount = $order->getFreeSousAmount();
            $orderTotal = 0;

            foreach($orderData as $i => $item)
            {
                $orderTotal += (int)$item['price'] * (int)$item['quantity'];
            }

            if ($freeSousAmount) 
            {
                $orderTotal = $orderTotal - ($freeSousAmount * 30);
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

        $count = (int)$query->count();
        $avg = ($count !== 0 && $total !== 0) ? floor($total / $count) : 0;
        $perDay = $count / $range['daysGap'];

        return [
            'ordersCount' => $count,
            'avg' => $avg,
            'perDay' => number_format((float)$perDay, 1, '.', ''),
            'totalSumm' => $total,
            'biggest' => [
                'summ' => $biggestTotal,
                'order' => $biggestOrder
            ],
            'reports' => $reports
        ];
    }

    public static function getRangeInfo(array $data): array
    {
        $start = 0;
        
        if ($data['start'] == 0) {
            $firstOrderTimestamp = (int)CartOrder::findBySql("SELECT MIN(created_at) from cart_order WHERE name <> 'test' AND status = 1")->scalar();
            $start = $firstOrderTimestamp;
        } else {
            $start = strtotime($data['start']);
        }

        $end = strtotime('tomorrow', strtotime($data['end'])) - 1;
        $diff = $end - $start;
        $daysGap = round($diff / (60 * 60 * 24));

        return [
            'startTimestamp' => $start,
            'endTimestamp' => $end,
            'daysGap' => $daysGap
        ];
    }

    public static function getProductCrossSell(int $product_id)
    {

        $orderIds = Yii::$app->db->createCommand(
            "SELECT `cart_order`.`id` as `order_id` from `cart_order` 
                LEFT JOIN `cart_order_item` on `cart_order`.`id` = `cart_order_item`.`order_id` 
                WHERE `cart_order_item`.`product_id` = :pid")
            ->bindValue(':pid', $product_id)
            ->queryColumn();

        $placeholders = str_repeat('?,', count($orderIds) - 1). '?';

        $query = Yii::$app->db->createCommand(
            "SELECT MAX(`dish`.`title`) as 'title', COUNT(`dish`.`id`) as 'count' FROM `cart_order_item`
                LEFT JOIN `dish` on `cart_order_item`.`product_id` = `dish`.`id`
                WHERE `cart_order_item`.`order_id` IN ($placeholders)
                AND `cart_order_item`.`product_id` <> $product_id
                GROUP BY `cart_order_item`.`product_id`
                ORDER BY count DESC
                LIMIT 5"
        );

        foreach($orderIds as $i => $id) 
        {
            $query->bindValue($i + 1, $id);
        }

        $data =  $query->queryAll();

        return $data;
    }

    public static function fillDaysMap()
    {
        $days = [
            1 => [],
            2 => [],
            3 => [],
            4 => [],
            5 => [],
            6 => [],
            7 => []
        ];

        foreach($days as &$day) 
        {
           for($i = 7; $i <= 23; $i++)
           {
               $hour = $i > 9 ? "$i" : "0$i";
                $day[$hour] = [
                    "hour" => $hour,
                    "count" => 0,
                    "categories" => [
                        'data' => [],
                        'totalAmount' => 0
                    ]
                ];
           } 
        }

        return $days;
    }

    public static function getOrderCategories(CartOrder $order): array
    {

        $query = Yii::$app->db->createCommand(
            "SELECT SUM(`cart_order_item`.`quantity`) as 'quantity', MAX(`categories`.`title`) as 'title', `categories`.`id` FROM `cart_order_item`
                INNER JOIN `dish` ON `cart_order_item`.`product_id` = `dish`.`id`
                INNER JOIN `categories` ON `dish`.`category_id` = `categories`.`id`
                WHERE `cart_order_item`.`order_id` = :order_id
                GROUP BY `categories`.`id`
            "
        )->bindValue(':order_id', $order->id);

        return $query->queryAll();
    }
}