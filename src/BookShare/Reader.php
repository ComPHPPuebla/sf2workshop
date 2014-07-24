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
     * @param integer $points
     */
    public function addPoints($points)
    {
        $this->points += $points;
    }
}
