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
            $table->boolean('sexe');
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
        Schema::table('participants', function($table)
        {
            $table->dropColumn('sexe');
            $table->dropColumn('naissance');
            $table->dropColumn('adresse');
            $table->dropColumn('nom_parent');
            $table->dropColumn('telephone');
        }); 
    }
}
