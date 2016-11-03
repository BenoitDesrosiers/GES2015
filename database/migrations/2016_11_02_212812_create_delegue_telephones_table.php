<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDelegueTelephones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DelegueTelephones', function (Blueprint $table) {
            $table->integer('delegue_id');
            $table->string("telephone");
            $table->foreign('delegue_id')->references('id')
                ->on('delegues')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DelegueTelephones');
    }
}

