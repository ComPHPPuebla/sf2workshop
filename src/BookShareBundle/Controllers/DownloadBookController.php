<?php
namespace BookShareBundle\Controllers;

use Framework\Controller;
use BookShare\Persistence\Pdo\AllBooks;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Framework\Events\ProvidesEvents;
use BookShare\BooksEvents;use BookShare\ReaderPointsUpdateEvent;

class DownloadBookController
{

    use Controller, ProvidesEvents;
    protected $allBooks;

    public function __construct(AllBooks $allBooks)
    {
        $this->allBooks = $allBooks;
    }

    public function downloadBookAction($bookId)
    {
        is_user_logged();

        $book = $this->allBooks->ofBookId($bookId);

        $response = new BinaryFileResponse("/uploads/{$book['filename']}");
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $book['filename']
        );

        $response->headers->set('Content-Disposition', $disposition);
        $this->dispatcher->dispatch(
            BooksEvents::BOOK_DOWNLOADED,
            new ReaderPointsUpdateEvent(get_user_information('username'), -2)
        );

        return $response;
    }
}
