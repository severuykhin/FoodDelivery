<?php

namespace console\controllers;

use yii\console\Controller;
use common\models\CartOrder;
use common\models\Category;
use Yii;
use common\services\gender\LocalGenderService;
use common\dto\OrderItem;
use common\dto\Order;
use common\services\elastic\ElasticOrderItem;

// ElasticOrder
// ElasticRepository
// GenderResolver

class ElasticController extends Controller
{
    public function actionIndex()
    {

        $data = json_decode(file_get_contents('https://shymovka43.ru/feed'), true);
        $genderResolver = new LocalGenderService('Russia');

        foreach($data as $o_item) {

            $order = new Order($o_item['data'], $genderResolver);

            foreach($o_item['items'] as $index => $item) {
                $orderItem = new OrderItem($item);
                $elasticOrderItem = new ElasticOrderItem($orderItem, $order);
                $res = $elasticOrderItem->save();

                echo $res . ' ' . $index . PHP_EOL;
            }
        }    
    }
}