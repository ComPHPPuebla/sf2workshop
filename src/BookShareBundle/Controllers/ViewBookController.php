<?php
namespace BookShareBundle\Controllers;

use Framework\Controller;
use BookShare\AllBooks;

class ViewBookController
{
    use Controller;

    /** @var AllBooks */
    protected $allBooks;

    /**
     * @param AllBooks $allbooks
     */
    public function __construct(AllBooks $allBooks)
    {
       $this->allBooks = $allBooks;
    }

    /**
     * @param  integer                                    $bookId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewBookAction($bookId)
    {
        is_user_logged();

        return $this->renderResponse('view-book.html.twig', ['book' => $this->allBooks->ofBookId($bookId)]);
    }
}
