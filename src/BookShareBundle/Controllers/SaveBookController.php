<?php
namespace BookShareBundle\Controllers;

use BookShare\Persistence\Pdo\AllBooks;
use Framework\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use BookShare\Book;
use BookShare\Author;
use PDO;

class SaveBookController
{
    use Controller;

    protected $allBooks;
    protected $connection;

    public  function __construct(
        AllBooks $allBooks, PDO $connection
    )
    {
        $this->allBooks = $allBooks;
        $this->connection = $connection;
    }

    public function saveBookAction(Request $request)
    {
		$title = $request->request->filter('title');
		$authorId = $request->request->filter('author-id');
		$file = $request->files->get('file');
		$filename = $file->getClientOriginalName();
		$file->move('uploads/', $filename);

		$this->allBooks->add(new Book($title, $filename, new Author($authorId)));

		$sql = 'UPDATE user SET points = points + ? WHERE username = ?';
		query($this->connection, $sql, [APP_POINTS_SHARE_BOOK, get_user_information('username')]);

		return new RedirectResponse('/index.php/books');
    }
}

