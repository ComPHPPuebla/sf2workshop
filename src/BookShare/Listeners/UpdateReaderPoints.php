<?php
namespace BookShare\Listeners;

use BookShare\ReaderPointsUpdateEvent;
use BookShare\AllReaders;

class UpdateReaderPoints
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
     * @param ReaderPointsUpdateEvent $event
     */
    public function updateReaderPoints(ReaderPointsUpdateEvent $event)
    {
        $reader = $this->allReaders->ofUsername($event->getUsername());
        $reader->addPoints($event->getPoints());
        $this->allReaders->update($reader);
    }

    /**
     * @param ReaderPointsUpdateEvent $event
     */
    public function __invoke(ReaderPointsUpdateEvent $event)
    {
        $this->updateReaderPoints($event);
    }
}
