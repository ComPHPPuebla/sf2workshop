<?php
namespace BookShareBundle\Controllers;

use BookShare\Persistence\Pdo\AllBooks;
use Framework\Controller;

class ViewBooksController
{
    use Controller;

    public function viewBooksAction()
    {
        is_user_logged();

        $allBooks = new AllBooks(db_connect());

        return $this->renderResponse('view-books.phtml', ['books' => $allBooks->withBestRate()]);
    }
}
