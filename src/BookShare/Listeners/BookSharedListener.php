<?php
namespace BookShare\Listeners;

use BookShare\BookSharedEvent;
use BookShare\AllReaders;

class BookSharedListener
{
    /** @var AllReaders */
    protected $allReaders;

    /**
     * @param AllReaders $allReaders
     */
    public function __construct(AllReaders $allReaders)
    {
        $this->allReaders = $allReaders;
    }

    /**
     * @param BookSharedEvent $event
     */
    public function updateReaderPoints(BookSharedEvent $event)
    {
        $reader = $this->allReaders->ofUsername($event->getUsername());
        $reader->addPoints(15);
        $this->allReaders->update($reader);
    }

    /**
     * @param BookSharedEvent $event
     */
    public function __invoke(BookSharedEvent $event)
    {
        $this->updateReaderPoints($event);
    }
}
