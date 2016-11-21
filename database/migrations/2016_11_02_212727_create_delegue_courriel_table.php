<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDelegueCourrielTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        {
            Schema::create('Delegue_Courriels', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('delegue_id');
                $table->string("courriel");
                $table->timestamps();
                $table->foreign('delegue_id')->references('id')
                    ->on('delegues')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Delegue_Courriels');
    }
}