<?php namespace Nwidart\LaravelBroadway\Registries;

use Broadway\CommandHandling\CommandBusInterface;

class CommandRegistry implements Registry
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
     * @param array $commandHandlers
     */
    public function add(array $commandHandlers)
    {
        foreach ($commandHandlers as $commandHandler) {
            $this->commandBus->subscribe($commandHandler);
        }
    }
}
