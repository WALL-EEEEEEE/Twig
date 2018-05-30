<?php
namespace Twig\Event;

trait Dispatcher {
    private $dispatchers = [];

    public function dispatch(Event $event, $status=NULL) {
        if (!in_array($event->type(),$this->events)) {
            throw new EventError('Unknow Event type -> '.$event->type);
        } else {
            //process resident event in queue at first
            $handler = @$this->listeners[$event->type()];
            if (!is_null($handler)) {
                return $handler($status);
            } 
        }
    }
}
