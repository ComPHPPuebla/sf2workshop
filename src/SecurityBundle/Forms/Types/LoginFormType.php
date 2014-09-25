<?php
namespace SecurityBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class LoginFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', [
                'label' => 'Username',
                'attr' => ['class' => 'form-control'],
                'constraints' => new NotBlank(),
            ])
            ->add('password', 'password', [
                'label' => 'Password',
                'attr' => ['class' => 'form-control'],
                'constraints' => new NotBlank(),
            ])
            ->add('login', 'submit', [
                'label' => 'Login',
                'attr' => ['class' => 'btn btn-default'],
            ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'login';
    }
}
