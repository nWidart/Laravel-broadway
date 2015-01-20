<?php namespace Nwidart\LaravelBroadway\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class CreateEventStoreCommand extends Command
{
    protected $name = 'broadway:event-store:migrate';
    protected $description = 'This will create the events store table based on the name in the configuration';

    public function fire()
    {
        $table = $this->argument('table');
        $this->laravel->config['laravel-broadway::event-store-table'] = $table;

        $this->call('migrate', ['--package' => 'nwidart/laravel-broadway']);

        $table = $this->laravel->config['laravel-broadway::event-store-table'];
        $this->info("Table [$table] created!");
    }

    protected function getArguments()
    {
        return [
            ['table', InputArgument::REQUIRED, 'Override the event store table name']
        ];
    }
}
