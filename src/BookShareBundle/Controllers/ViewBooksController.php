<?php
namespace BookShareBundle\Controllers;

use BookShare\Persistence\Pdo\AllBooks;
use Framework\Controller;

class ViewBooksController
{
    use Controller;
	protected $allBooks;
	public function __construct(AllBooks $allbooks)
	{
	   $this->allBooks = $allbooks;
	   
	}
    public function viewBooksAction()
    {
        is_user_logged();

            return $this->renderResponse('view-books.phtml', ['books' => $this->allBooks->withBestRate()]);
    }
}
