<?php
namespace Security\Persistence\Doctrine2;

use Doctrine\ORM\EntityRepository;
use Security\AllUsers as AllUsersInterface;

class AllUsers extends EntityRepository implements AllUsersInterface
{
    /**
     * @param  string         $username
     * @return \Security\User
     */
    public function ofUsername($username)
    {
        $builder = $this->createQueryBuilder('u');
        $builder
            ->where('u.username = :username')
            ->setParameter('username', $username);

        return $builder->getQuery()->getOneOrNullResult();
    }
}
