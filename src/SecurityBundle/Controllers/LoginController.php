<?php
namespace SecurityBundle\Controllers;

use Framework\Controller;
use SecurityBundle\Forms\Types\LoginFormType;
use Symfony\Component\Form\FormFactory;

class LoginController
{
    use Controller;

    /** @var FormFactory */
    protected $formFactory;

    /**
     * @param FormFactory $formFactory
     */
    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        return $this->renderResponse('login.html.twig', [
            'form' => $this->formFactory->create(new LoginFormType())->createView(),
        ]);
    }
}
