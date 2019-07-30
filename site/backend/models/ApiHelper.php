<?php

namespace backend\models;

use common\models\CartOrder;
use common\models\Report;

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

            if ($order['name'] == 'test' || $order['status'] != CartOrder::STATUS_VIEWED) continue;

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
}