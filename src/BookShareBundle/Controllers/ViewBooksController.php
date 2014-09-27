<?php
namespace BookShareBundle\Controllers;

use BookShare\AllBooks;
use Framework\Controller;

class ViewBooksController
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
    public function viewBooksAction()
    {
        is_user_logged();

        return $this->renderResponse('view-books.html.twig', ['books' => $this->allBooks->withBestRate()]);
    }
}
