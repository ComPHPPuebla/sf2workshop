<?php
namespace BookShareBundle\Controllers;

use Framework\Controller;
use BookShare\Persistence\Pdo\AllBooks;

class ViewBookController
{
    use Controller;

    public function viewBookAction($bookId)
    {
        is_user_logged();

        $allBooks = new AllBooks(db_connect());

        return $this->renderResponse('view-book.phtml', ['book' => $allBooks->ofBookId($bookId)]);

    }
}
