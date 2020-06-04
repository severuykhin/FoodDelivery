<?php

namespace common\interfaces;

use common\interfaces\EventInterface;

interface EventListenderInterface
{
    public function handle(EventInterface $event);
}