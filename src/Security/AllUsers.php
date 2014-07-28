<?php
namespace Security;

interface AllUsers
{
    /**
     * @param string $username
     */
    public function ofUsername($username);
}
