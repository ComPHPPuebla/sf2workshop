<?php
use BookShare\Persistence\Pdo\AllBooks;
use Symfony\Component\HttpFoundation\Request;
use BookShare\Book;
use BookShare\Author;

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

function save_book(Request $request)
{
	$title = $request->request->filter('title');
	$authorId = $request->request->filter('author-id');
	$file = $request->files->get('file');
	$filename = $file->getClientOriginalName();
	$file->move('uploads/',$filename);
	//move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $filename);

	$conn = db_connect();
	$allBooks = new AllBooks($conn);
	$allBooks->add(new Book($title, $filename, new Author($authorId)));

	$sql = 'UPDATE user SET points = points + ? WHERE username = ?';
	query($conn, $sql, [APP_POINTS_SHARE_BOOK, get_user_information('username')]);

	header('Location: /index.php/books');
	exit();
}

