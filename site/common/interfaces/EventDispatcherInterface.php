<?php

namespace common\interfaces;

use common\interfaces\EventInterface;

interface EventDispatcherInterface
{
    public function dispatch(EventInterface $event);
}