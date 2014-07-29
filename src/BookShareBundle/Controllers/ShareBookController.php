<?php
namespace BookShareBundle\Controllers;

use BookShare\Persistence\Pdo\AllBooks;
use Framework\Controller;

class ShareBookController
{
    use Controller;

    public function shareBooksAction()
    {
        is_user_logged();
        $allBooks = new AllBooks(db_connect());
	    $allBooks = $allBooks->AllAuthors();
        

        return $this->renderResponse('share-book.phtml', ['authors' => $allBooks]);
    }
}
class 

