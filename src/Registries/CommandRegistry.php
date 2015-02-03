<?php namespace Nwidart\LaravelBroadway\Registries;

use Broadway\CommandHandling\CommandBusInterface;

class CommandRegistry extends BaseRegistry implements Registry
{
    /**
     * @var CommandBusInterface
     */
    private $commandBus;

    /**
     * @param CommandBusInterface $commandBus
     */
    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Subscribe the given array of command handlers on the command bus
     * @param array $handlers
     */
    public function subscribe($handlers)
    {
        $handlers = $this->isTraversable($handlers) ? $handlers : [$handlers];

        foreach ($handlers as $commandHandler) {
            $this->commandBus->subscribe($commandHandler);
        }
    }
}
