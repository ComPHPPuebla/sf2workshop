<?php
use BookShare\Persistence\Pdo\AllBooks;
use Symfony\Component\HttpFoundation\Request;

function view_books()
{
    is_user_logged();

    $allBooks = new AllBooks(db_connect());

    return ['books' =>$allBooks->withBestRate()];
}

function view_book(Request $request)
{
    is_user_logged();

    $bookId = $request->attributes->getInt('bookId');
    $allBooks = new AllBooks(db_connect());

    return ['book' => $allBooks->ofBookId($bookId)];
}

function search_books(Request $request)
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

    return ['books' => $books];

}
