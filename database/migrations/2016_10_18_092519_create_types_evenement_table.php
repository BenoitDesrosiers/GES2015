<?php
/**
 * @author Jessee
 * @version 0.0.1 rev 1
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypesEvenementTable extends Migration
{
    /**
     * Exécute la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types_evenement', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titre');
            $table->timestamps();
        });
    }

    /**
     * Annule la migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('types_evenement');
    }
}
