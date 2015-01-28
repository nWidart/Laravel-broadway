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

    public function __construct()
    {
        $this->eventStoreTableName = Config::get('laravel-broadway::event-store-table', 'event_store');
    }

    public function up()
    {
        Schema::create($this->eventStoreTableName, function (Blueprint $table) {
            $table->increments('id');

            $table->string('uuid', 255);
            $table->string('playhead', 255);
            $table->string('metadata', 255);
            $table->string('payload', 255);
            $table->dateTime('recorded_on');
            $table->string('type', 255);

            $table->unique(['uuid', 'playhead']);
        });
    }

    public function down()
    {
        Schema::drop($this->eventStoreTableName);
    }
}
