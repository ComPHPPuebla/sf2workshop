<?php
namespace BookShareBundle\Controllers;

use BookShare\AllBooks;
use BookShare\BooksEvents;
use BookShare\ReaderPointsUpdateEvent;
use Framework\Controller;
use Framework\Events\ProvidesEvents;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DownloadBookController
{
    use Controller, ProvidesEvents;

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
     * @param  integer            $bookId
     * @return BinaryFileResponse
     */
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
