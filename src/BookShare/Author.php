<?php
namespace BookShare;

class Author
{
    /** @type integer */
    protected $authorId;

    /** @type string */
    protected $name;

    /**
     * @param integer $authorId
     * @param string  $name
     */
    public function __construct($authorId, $name = null)
    {
        $this->authorId = $authorId;
        $this->name = $name;
    }

    /**
     * @return integer
     */
    public function id()
    {
        return $this->authorId;
    }
}
