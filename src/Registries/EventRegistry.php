<?php namespace Nwidart\LaravelBroadway\Registries;

use Broadway\EventHandling\EventBusInterface;

class EventRegistry implements Registry
{

    /**
     * @var EventBusInterface
     */
    private $eventBus;

    public function __construct(EventBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    /**
     * Subscribe the given array of projectors on the event bus
     * @param array $projectors
     * @return void
     */
    public function add(array $projectors)
    {
        foreach ($projectors as $projector)
        {
            $this->eventBus->subscribe($projector);
        }
    }
}
