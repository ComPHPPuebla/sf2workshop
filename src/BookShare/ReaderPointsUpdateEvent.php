<?php
namespace BookShare;

use Symfony\Component\EventDispatcher\Event;

class ReaderPointsUpdateEvent extends Event
{
    /** @var string */
    protected $username;

    /** @var integer */
    protected $points;

    /**
     * @param string  $username
     * @param integer $points
     */
    public function __construct($username, $points)
    {
        $this->username = $username;
        $this->points = $points;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return integer
     */
    public function getPoints()
    {
        return $this->points;
    }
}
