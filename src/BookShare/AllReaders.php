<?php
namespace BookShare;

interface AllReaders
{
    /**
     * @param Reader $reader
     */
    public function update(Reader $reader);

    /**
     * @param  string $username
     * @return Reader
     */
    public function ofUsername($username);
}
