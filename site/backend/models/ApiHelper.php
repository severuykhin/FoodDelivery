<?php

namespace backend\models;

use common\models\CartOrder;

class ApiHelper 
{
    public static function getOrdersSummary(array $data): array
    {
        $query = CartOrder::find();
        
        $range = self::getRangeInfo($data);

        $query->andWhere(['>=', 'created_at', $range['startTimestamp']]);
        $query->andWhere(['<=', 'created_at', $range['endTimestamp']]);

        $total = 0;
        $biggestTotal = 0;
        $biggestOrder = [
            'details' => [],
            'data' => []
        ];

        foreach($query->each() as $index => $order)
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
            ]
        ];
    }

    public static function getRangeInfo(array $data): array
    {
        $start;
        if ($data['start'] == 0) {
            $firstOrderTimestamp = (int)CartOrder::findBySql("SELECT MIN(created_at) from cart_order WHERE name <> 'test'")->scalar();
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
}