<?php

namespace common\events;

use common\events\Event;
use common\models\CartOrder;

class OrderCreateEvent extends Event
{
    public $order;


    public function __construct(CartOrder $order)
    {
        $this->order = $order;
    }
}