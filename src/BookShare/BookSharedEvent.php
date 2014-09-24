<?php
namespace BookShare;

use Symfony\Component\EventDispatcher\Event;

class BookSharedEvent extends Event
{
    protected $username;
    protected $points;

    public function __construct($username, $points)
    {
        $this->username = $username;
        $this->points = $points;
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function getPoints()
    {
        return $this->points;
    }
} 