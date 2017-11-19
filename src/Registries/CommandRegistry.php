<?php namespace Nwidart\LaravelBroadway\Registries;

use Broadway\CommandHandling\CommandBus;

class CommandRegistry extends BaseRegistry implements Registry
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
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
