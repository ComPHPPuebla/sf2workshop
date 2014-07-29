<?php
namespace BookShareBundle\Controllers;

use BookShare\Persistence\Pdo\AllBooks;
use Framework\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use BookShare\Book;
use BookShare\Author;

class SaveBookController
{
    use Controller;

    public function saveBookAction(Request $request)
    {
		$title = $request->request->filter('title');
		$authorId = $request->request->filter('author-id');
		$file = $request->files->get('file');
		$filename = $file->getClientOriginalName();
		$file->move('../uploads/',$filename);

		$conn = db_connect();
		$allBooks = new AllBooks($conn);
		$allBooks->add(new Book($title, $filename, new Author($authorId)));

		$sql = 'UPDATE user SET points = points + ? WHERE username = ?';
		query($conn, $sql, [APP_POINTS_SHARE_BOOK, get_user_information('username')]);

		return new RedirectResponse('/index.php/books');
		
		
		//is_user_logged();

        //$allBooks = new AllBooks(db_connect());

        //return $this->renderResponse('view-books.phtml', ['books' => $allBooks->withBestRate()]);
    }
}

