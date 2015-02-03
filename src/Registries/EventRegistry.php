<?php namespace Nwidart\LaravelBroadway\Registries;

use Broadway\EventHandling\EventBusInterface;

class EventRegistry extends BaseRegistry implements Registry
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
     * @param  array $projectors
     */
    public function subscribe($projectors)
    {
        $projectors = $this->isTraversable($projectors) ? $projectors : [$projectors];

        foreach ($projectors as $projector) {
            $this->eventBus->subscribe($projector);
        }
    }
}
