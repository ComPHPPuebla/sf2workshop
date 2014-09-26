<?php
namespace BookShareBundle\Controllers;

use BookShare\BooksEvents;
use BookShare\ReaderPointsUpdateEvent;
use BookShare\Persistence\Pdo\AllBooks;
use Framework\Controller;
use Framework\Events\ProvidesEvents;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use BookShare\Book;
use BookShare\Author;
use BookShareBundle\Forms\Types\ShareBookFormType;

class SaveBookController
{
    use Controller, ProvidesEvents;

    /** @var AllBooks */
    protected $allBooks;

    /** @var FormFactory */
    protected $formFactory;

    /**
     * @param AllBooks $allBooks
     */
    public function __construct(AllBooks $allBooks, FormFactory $formFactory)
    {
        $this->allBooks = $allBooks;
        $this->formFactory = $formFactory;
    }

    /**
     * @param  Request          $request
     * @return RedirectResponse
     */
    public function saveBookAction(Request $request)
    {
        $form = $this->formFactory->create(new ShareBookFormType($this->allBooks));
        $form -> handleRequest($request);

        if ($form-> isValid()) {
            $book = $form -> getData();

            $title = $book['title'];
            $authorId = $book['author-id'];

            /** @var UploadedFile $file */
            $file = $form['file']->getData();
            $filename = $file->getClientOriginalName();
            $file->move('uploads/', $filename);

            $this->allBooks->add(new Book($title, $filename, new Author($authorId)));

            $this->dispatcher->dispatch(
                BooksEvents::BOOK_SHARED,
                new ReaderPointsUpdateEvent(get_user_information('username'), 15)
            );

            return new RedirectResponse('/index.php/books');
        }

        return $this->renderResponse('share-book.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
