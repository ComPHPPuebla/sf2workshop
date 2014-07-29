<?php
namespace BookShareBundle\Controllers;

use Framework\Controller;
use Symfony\Component\HttpFoundation\Request;
use BookShare\Persistence\Pdo\AllBooks;

class SearchBooksController
{
    use Controller;

    public function searchBooksAction(Request $request)
    {
        is_user_logged();


        $searchType = $request->request->filter('search-type');
        $searchTerm = $request->request->filter('book-search');

        $allBooks = new AllBooks(db_connect());

        if ('title' === $searchType) {
            $books = $allBooks->ofTitleLike($searchTerm);
        } else {
            $books = $allBooks->ofAuthorNameLike($searchTerm);
        }

        return $this->renderResponse('search-books.phtml', ['books' => $books]);
    }
}
