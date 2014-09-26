<?php
namespace Security;

interface AllUsers
{
    /**
     * @param  string $username
     * @return User
     */
    public function ofUsername($username);
}
