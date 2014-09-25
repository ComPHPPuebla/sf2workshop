<?php
namespace BookShareBundle\Controllers;

use BookShare\Persistence\Pdo\AllBooks;
use Framework\Controller;

class ShareBookController
{
    use Controller;
    protected $allBooks;

    public function __construct(AllBooks $allBooks)
    {
        $this->allBooks = $allBooks;
    }
    public function shareBookAction()
    {
        is_user_logged();

        $allAuthors = $this->allBooks->allAuthors();

        return $this->renderResponse('share-book.html.twig', ['authors' => $allAuthors]);
    }
}
