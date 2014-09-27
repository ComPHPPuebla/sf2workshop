<?php
namespace BookShareBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use BookShare\Persistence\Pdo\AllBooks;

class ShareBookFormType extends AbstractType
{
    /**
     * @param AllBooks $allBooks
     */
    public function __construct(AllBooks $allBooks)
    {
        $this->allBooks = $allBooks;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', [
                'label' => 'Title',
                'attr' => ['class' => 'form-control'],
                'constraints' => new NotBlank(),
            ])
            ->add('author-id', 'choice', [
                'choices'   => $this->getAuthorChoices(),
                'label' => 'Author',
                'attr' => ['class' => 'form-control'],
                'constraints' => new NotBlank(),
            ])
            ->add('file', 'file', [
                'label' => 'File',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('submit', 'submit', [
                'label' => 'Submit',
                'attr' => ['class' => 'btn btn-default'],
            ]);
    }

    /**
     * @return array
     */
    protected function getAuthorChoices()
    {
        $authors = $this->allBooks->allAuthors();
        $choices = [];
        foreach ($authors as $author) {
            $choices[$author['author_id']] = $author['name'];
        }

        return $choices;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'share_book';
    }
}
