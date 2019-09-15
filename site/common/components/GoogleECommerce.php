<?php

namespace common\components;

use common\models\CartOrder;
use common\models\CartOrderItem;
use yii\helpers\VarDumper;
use common\models\Category;

class GoogleECommerce 
{
    private $url            = 'https://www.google-analytics.com/collect';
    private $tid            = 'UA-138651791-1';
    private $store_name     = 'Шумовка';
    private $shipping_cost  = 0;  // TO DO - implement dynamic shipping cost value
    private $tax            = 0;
    private $order          = null;
    private $freeSousAmount = 0; 
    private $uuid           = ''; 
    private $orderItems     = null;

    public function __construct(CartOrder $order)
    {
        $this->order = $order;
        $this->freeSousAmount = $order->getFreeSousAmount();
        $this->uuid = $this->getUuid();
        $this->orderItems = $order->compile();
    }

    public function sendOrder()
    {
        $this->transactionOrder();        
        foreach($this->orderItems as $item)
        {
           $this->transactionItem($item);
        }
    }

    private function transactionOrder() 
    {

        $transactionData = [
            'v'   => 1,
            'tid' => $this->tid,
            't'   => 'transaction',
            'cid' => $this->uuid,
            'ti'  => $this->order->id,
            'tr'  => $this->order->countTotal(),
            'ta'  => $this->store_name,
            'ts'  => $this->shipping_cost,
            'tt'  => $this->tax,
        ];

        $result = $this->sendData($transactionData);

        return $result;
    }

    private function transactionItem(array $orderItem)
    {   
        $category = Category::findOne($orderItem['category_id']);

        $item_price = $orderItem['price'];

        if ($category->id === 20 && $this->freeSousAmount > 0) { // If free sous
            $item_price = number_format(0, 2, '.', ','); // 0.00
            $this->freeSousAmount -= $orderItem['quantity'];
        }

        $transactionData = [
            'v' => 1,
            'tid' => $this->tid,
            'cid' => $this->uuid,
            't' => 'item',
            'ti' => $orderItem['order_id'],
            'in' => $orderItem['title'] . ' ' . $orderItem['size'],
            'ip' => $item_price,
            'iq' => $orderItem['quantity'],
            'ic' => $orderItem['id'] . $orderItem['mId'], // ID продукта + ID модификации продукта
            'iv' => $category->title
        ];

        $result = $this->sendData($transactionData);

        return $result;
    }

    private function getUuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff));
    }

    private function sendData(array $params)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }
}