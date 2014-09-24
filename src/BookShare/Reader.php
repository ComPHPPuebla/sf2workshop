<?php
namespace BookShare;

class Reader
{
    /** @type integer */
    protected $points;

    /** @type string */
    protected $displayName;

    /** @type string */
    protected $username;

    public function __construct($username, $points = 0)
    {
        $this->username = $username;
        $this->points = $points;
    }

    public function username()
    {
        return $this->username;
    }

    public function points()
    {
        return $this->points;
    }

    /**
     * @param integer $points
     */
    public function addPoints($points)
    {
        $this->points += $points;
    }
}
