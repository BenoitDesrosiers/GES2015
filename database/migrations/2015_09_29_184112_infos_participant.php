<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InfosParticipant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participants',function($table)
        {
            $table->unsignedInteger('sexe');
            // Pour gérer les cas de troisième genre, utiliser un int plutot qu'un booleen
            $table->date('naissance');
            $table->string('adresse')->nullable();
            $table->string('nom_parent')->nullable();
            $table->string('telephone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('epreuves', function($table)
        {
            $table->dropColumn('sexe');
            $table->dropColumn('naissance');
            $table->dropColumn('adresse');
            $table->dropColumn('nom_parent');
            $table->dropColumn('telephone');
        }); 
    }
}
