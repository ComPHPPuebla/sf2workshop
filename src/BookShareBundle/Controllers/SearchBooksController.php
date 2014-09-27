<?php
namespace BookShareBundle\Controllers;

use BookShare\AllBooks;
use Framework\Controller;
use Symfony\Component\HttpFoundation\Request;

class SearchBooksController
{
    use Controller;

    /** @var AllBooks */
    protected $allBooks;

    /**
     * @param AllBooks $allBooks
     */
    public function __construct(AllBooks $allBooks)
    {
        $this->allBooks = $allBooks;
    }

    /**
     * @param  Request                                    $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
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
