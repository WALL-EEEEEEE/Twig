<?php
namespace Twig\Event;

trait EventDispatch {

    public function dispatch( Event $event ) {
        if (!in_array($event->type(),$this->events)) {
            throw new EventError('Unknow Event type -> '.$event->type);
        } else {
            $this->__call($event->type());
        }
    }
}
