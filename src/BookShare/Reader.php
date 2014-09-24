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

    /**
     * @param string  $username
     * @param integer $points
     */
    public function __construct($username, $points = 0)
    {
        $this->username = $username;
        $this->points = $points;
    }

    /**
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    /**
     * @return integer
     */
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
