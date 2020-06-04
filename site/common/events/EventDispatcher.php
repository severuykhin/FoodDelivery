<?php

namespace common\events;

use common\interfaces\EventInterface;
use common\interfaces\EventDispatcherInterface;

class EventDispatcher implements EventDispatcherInterface
{

    private $listeners = [];

    public function __construct(array $listeners)
    {
        $this->listeners = $listeners;
    }

    public function dispatch(EventInterface $event)
    {
        $eventName = get_class($event);
        if (isset($this->listeners[$eventName])) {
            foreach($this->listeners[$eventName] as $listenerClass) {
                $listener = \Yii::$container->get($listenerClass);
                $listener->handle($event);
            }
        }
    }
}