<?php
namespace BookShare;

use Symfony\Component\EventDispatcher\Event;

class BookSharedEvent extends Event
{
    protected $username;

    public function __construct($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }
} 