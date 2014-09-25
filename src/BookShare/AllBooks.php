<?php
namespace BookShare;

interface AllBooks
{
    /**
     * @param  integer $bookId
     * @return Book
     */
    public function ofBookId($bookId);

    /**
     * @param  string  $title
     * @return Books[]
     */
    public function ofTitleLike($title);

    /**
     * @param  string  $authorName
     * @return Books[]
     */
    public function ofAuthorNameLike($authorName);

    /**
     * @param Book $book
     */
    public function add(Book $book);

    /**
     * @return Book[]
     */
    public function withBestRate();
}
