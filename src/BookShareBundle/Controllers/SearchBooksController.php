<?php
namespace BookShareBundle\Controllers;

use Framework\Controller;
use Symfony\Component\HttpFoundation\Request;
use BookShare\Persistence\Pdo\AllBooks;

class SearchBooksController
{
    use Controller;
	
	protected $allBooks;
	
	public function __construct(AllBooks $allBooks)
    {
        $this->allBooks = $allBooks;
    }

    public function searchBooksAction(Request $request)
    {
        is_user_logged();


        $searchType = $request->request->filter('search-type');
        $searchTerm = $request->request->filter('book-search');

        if ('title' === $searchType) {
            $books = $this->allBooks->ofTitleLike($searchTerm);
        } else {
            $books = $this->allBooks->ofAuthorNameLike($searchTerm);
        }

        return $this->renderResponse('search-books.html.twig', ['books' => $books]);
    }
}
