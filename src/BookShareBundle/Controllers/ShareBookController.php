<?php
namespace BookShareBundle\Controllers;

use BookShare\Persistence\Pdo\AllBooks;
use BookShareBundle\Forms\Types\ShareBookFormType;
use Framework\Controller;
use Symfony\Component\Form\FormFactory;

class ShareBookController
{
    use Controller;

    /** @var AllBooks */
    protected $allBooks;

    /** @var FormFactory */
    protected $formFactory;

    /**
     * @param AllBooks    $allBooks
     * @param FormFactory $formFactory
     */
    public function __construct(AllBooks $allBooks, FormFactory $formFactory)
    {
        $this->allBooks = $allBooks;
        $this->formFactory = $formFactory;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function shareBookAction()
    {
        is_user_logged();

        return $this->renderResponse('share-book.html.twig', [
            'form' => $this->formFactory->create(new ShareBookFormType($this->allBooks))->createView()
        ]);
    }
}
