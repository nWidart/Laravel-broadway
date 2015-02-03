<?php namespace Nwidart\LaravelBroadway\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class CreateEventStoreCommand extends Command
{
    protected $name = 'broadway:event-store:migrate';
    protected $description = 'This will create the events store table based on the name in the configuration';

    public function fire()
    {
        $table = $this->argument('table');
        $this->laravel->config['broadway.event-store-table'] = $table;

        $migrations = app('migration.repository');
        $migrations->createRepository();

        $migrator = app('migrator');
        $migrator->run(__DIR__ . '/../../migrations');

        $this->info("Table [$table] created!");
    }

    protected function getArguments()
    {
        return [
            ['table', InputArgument::REQUIRED, 'Override the event store table name']
        ];
    }
}
