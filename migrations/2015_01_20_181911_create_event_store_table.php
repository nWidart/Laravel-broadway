<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class CreateEventStoreTable extends Migration
{
    /**
     * @var string
     */
    private $eventStoreTableName;

    private $eventStoreConnection;

    public function __construct()
    {
        $this->eventStoreTableName = Config::get('broadway.event-store-table', 'event_store');
        $this->eventStoreConnection = Config::get('broadway.event-store.connection', 'default');

        if ($this->eventStoreConnection === 'default') {
            $config = app(\Illuminate\Config\Repository::class);
            $this->eventStoreConnection = $config->get('database.default');
        }
    }

    public function up()
    {
        Schema::connection($this->eventStoreConnection)->create($this->eventStoreTableName, function (Blueprint $table) {
            $table->increments('id');

            $table->char('uuid', 36);
            $table->integer('playhead')->unsigned();
            $table->text('metadata');
            $table->text('payload');
            $table->string('recorded_on', 32);
            $table->text('type');

            $table->unique(['uuid', 'playhead']);
        });
    }

    public function down()
    {
        Schema::drop($this->eventStoreTableName);
    }
}
