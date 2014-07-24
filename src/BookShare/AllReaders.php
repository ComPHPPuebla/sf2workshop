<?php
namespace BookShare;

interface AllReaders
{
    /**
     * @param Reader $reader
     */
    public function update(Reader $reader);
}
