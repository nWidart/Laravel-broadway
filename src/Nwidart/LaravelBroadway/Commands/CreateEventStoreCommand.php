<?php namespace Nwidart\LaravelBroadway\Commands;

use Illuminate\Console\Command;

class CreateEventStoreCommand extends Command
{
    protected $name = 'broadway:migrate';
    protected $description = 'This will create the events store table based on the name in the configuration';

    public function fire()
    {
        $this->call('migrate', ['--package' => 'nwidart/laravel-broadway']);

        $this->info('Event Store table created');
    }
}
