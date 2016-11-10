<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganismeTable extends Migration
{
    /**
     * Exécuter la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organismes', function($table)
        {
            $table->increments('id');
            $table->string('nomOrganisme');
            $table->string('telephone')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Inverser la migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('organismes');
    }
}
