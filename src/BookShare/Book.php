<?php
namespace BookShare;

class Book
{
    /** @type integer */
    protected $bookId;

    /** @type string */
    protected $title;

    /** @type string */
    protected $filename;

    /** @type Author */
    protected $author;

    /**
     * @param string $title
     * @param string $filename
     * @param Author $author
     */
    public function __construct(
        $title, $filename, Author $author
    )
    {
        $this->title = $title;
        $this->filename = $filename;
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function filename()
    {
        return $this->filename;
    }

    /**
     * @return integer
     */
    public function authorId()
    {
        return $this->author->id();
    }

    public function bookId()
    {
        return $this->bookId;
    }
}
