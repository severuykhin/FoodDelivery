<?php

namespace common\dto;

class OrderItem
{
    public $site_id;
    public $order_id;
    public $title;
    public $price;
    public $quantity;
    public $category_id;

    public $full_id;

    public function __construct(array $data) 
    {
        $this->title = $data['title'];
        $this->order_id = $data['order_id'];
        $this->site_id = $data['id'];
        $this->price = (int)$data['price'];
        $this->quantity = $data['quantity'];
        $this->category_id = $data['category_id'];

        $this->full_id = $this->order_id . '-' . $this->site_id;
    }

    public function getCost(): int
    {
        return $this->quantity * $this->price;
    }
}