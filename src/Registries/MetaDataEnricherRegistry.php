<?php namespace Nwidart\LaravelBroadway\Registries;

use Broadway\EventSourcing\MetadataEnrichment\MetadataEnrichingEventStreamDecorator;

/**
 * Class MetaDataEnricherRegistry
 *
 * @package Nwidart\LaravelBroadway\Registries
 * @author Stefano Kowalke <blueduck@mailbox.org>
 */
class MetaDataEnricherRegistry extends BaseRegistry implements Registry
{
    /**
     * @var MetadataEnrichingEventStreamDecorator $eventStreamDecorator
     */
    private $eventStreamDecorator;

    /**
     * @param MetadataEnrichingEventStreamDecorator $eventStreamDecorator
     */
    public function __construct(MetadataEnrichingEventStreamDecorator $eventStreamDecorator)
    {
        $this->eventStreamDecorator = $eventStreamDecorator;
    }

    /**
     * Subscribe the given array of command handlers on the command bus
     * @param array $enrichers
     */
    public function subscribe($enrichers)
    {
        $enrichers = $this->isTraversable($enrichers) ? $enrichers : [$enrichers];

        foreach ($enrichers as $enricher) {
            $this->eventStreamDecorator->registerEnricher($enricher);
        }
    }

    /**
     * @return MetadataEnrichingEventStreamDecorator
     */
    public function getEventStreamDecorator()
    {
        return $this->eventStreamDecorator;
    }
}
