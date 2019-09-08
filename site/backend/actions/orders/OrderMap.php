<?php

namespace backend\actions\orders;

use Yii;
use backend\models\ApiHelper;
use common\models\CartOrder;

class OrderMap extends \yii\base\Action
{
    public function run()
    {
        $requestData = Yii::$app->request->get();

        $range = ApiHelper::getRangeInfo($requestData);
        
        $ordersQuery = CartOrder::find()
                        ->where(['status' => CartOrder::STATUS_VIEWED])
                        ->andWhere(['>=', 'created_at', $range['startTimestamp']])
                        ->andWhere(['<=', 'created_at', $range['endTimestamp']]);
        
        $ordersCount = $ordersQuery->count();

        $daysMap = ApiHelper::fillDaysMap();

        foreach($ordersQuery->each() as $order)
        {
            $weekday = date('N', $order->created_at);
            $hour = date('H', $order->created_at);

            if (!isset($daysMap[$weekday][$hour])) continue;
            
            $categories = ApiHelper::getOrderCategories($order);

            $daysMap[$weekday][$hour]["count"] += 1;
            foreach($categories as $category)
            {
                if (isset($daysMap[$weekday][$hour]["categories"]['data'][$category['id']])) {
                    $daysMap[$weekday][$hour]["categories"]['data'][$category['id']]['quantity'] += $category['quantity'];
                } else {
                    $daysMap[$weekday][$hour]["categories"]['data'][$category['id']] = [
                        'id' => $category['id'],
                        'title' => $category['title'],
                        'quantity' => (int)$category['quantity'],
                        'percentage' => 0
                    ];
                }

                $daysMap[$weekday][$hour]['categories']['totalAmount'] += $category['quantity'];
            }

            foreach($daysMap[$weekday][$hour]['categories']['data'] as &$item)
            {
                $totalAmount = $daysMap[$weekday][$hour]['categories']['totalAmount'];
                $countPercentage = 100 / $totalAmount * $item['quantity'];
                $item['percentage'] = number_format((float) $countPercentage, 2, '.', '');
            }

        }

        return [
            "items" => $daysMap,
            "ordersCount" => $ordersCount
        ];
    }
}
