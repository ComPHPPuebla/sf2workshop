<?php
namespace BookShareBundle\Controllers;

use Framework\Controller;
use BookShare\Persistence\Pdo\AllBooks;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DownloadBookController
{
    use Controller;
	protected $allBooks;
	
	public function __construct(AllBooks $allBooks)
	{
		$this->allBooks = $allBooks;
	}
		
    public function downloadBookAction($bookId)
    {
        is_user_logged();
				
        /*
         * add points to user
        */
        $book = $this->allBooks->ofBookId($bookId);

        $response = new BinaryFileResponse(getcwd()."/uploads/{$book['filename']}");
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $book['filename']
        );

        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
