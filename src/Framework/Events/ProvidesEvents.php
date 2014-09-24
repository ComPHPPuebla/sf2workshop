<?php
namespace Framework\Events;


use Symfony\Component\EventDispatcher\EventDispatcher;

trait ProvidesEvents
{
    /** @var  EventDispatcher */
    protected $dispatcher;

    public function setDispatcher(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function addListener($eventName, callable $listener)
    {
        $this->dispatcher->addListener($eventName, $listener);
    }
} 