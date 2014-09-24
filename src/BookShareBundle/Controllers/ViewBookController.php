<?php
namespace BookShareBundle\Controllers;

use Framework\Controller;
use BookShare\Persistence\Pdo\AllBooks;

class ViewBookController
{
    use Controller;
	protected $allBooks;
	public function __construct(AllBooks $allbooks)
	{
	   $this->allBooks = $allbooks;
	   
	}

    public function viewBookAction($bookId)
    {
        is_user_logged();

        return $this->renderResponse('view-book.html.twig', ['book' => $this->allBooks->ofBookId($bookId)]);

    }
}
