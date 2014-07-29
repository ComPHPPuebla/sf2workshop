<?php
namespace BookShareBundle\Controllers;

use Framework\Controller;
use BookShare\Persistence\Pdo\AllBooks;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DownloadBookController
{
    use Controller;

    public function downloadBookAction($bookId)
    {
        is_user_logged();

        $allBooks = new AllBooks(db_connect());

        /*
         * add points to user
        */
        $book = $allBooks->ofBookId($bookId);

        $response = new BinaryFileResponse("../uploads/{$book['filename']}");
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $book['filename']
        );

        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
