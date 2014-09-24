<?php
namespace BookShareBundle\Controllers;

use BookShare\BooksEvents;
use BookShare\ReaderPointsUpdateEvent;
use BookShare\Persistence\Pdo\AllBooks;
use Framework\Controller;
use Framework\Events\ProvidesEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use BookShare\Book;
use BookShare\Author;

class SaveBookController
{
    use Controller, ProvidesEvents;

    /** @var AllBooks */
    protected $allBooks;

    /**
     * @param AllBooks $allBooks
     */
    public  function __construct(AllBooks $allBooks)
    {
        $this->allBooks = $allBooks;
    }

    /**
     * @param  Request          $request
     * @return RedirectResponse
     */
    public function saveBookAction(Request $request)
    {
		$title = $request->request->filter('title');
		$authorId = $request->request->filter('author-id');
		$file = $request->files->get('file');
		$filename = $file->getClientOriginalName();
		$file->move('uploads/', $filename);

		$this->allBooks->add(new Book($title, $filename, new Author($authorId)));

        $this->dispatcher->dispatch(
            BooksEvents::BOOK_SHARED,
            new ReaderPointsUpdateEvent(get_user_information('username'), 15)
        );

		return new RedirectResponse('/index.php/books');
    }
}
