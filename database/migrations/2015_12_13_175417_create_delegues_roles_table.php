<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeleguesRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delegues_roles', function (Blueprint $table) {
            $table->unsignedInteger('delegue_id');
			$table->unsignedInteger('role_id');
			$table->foreign('delegue_id')
					->references('id')
					->on('delegues')
					->onDelete('cascade')
					->onUpdate('cascade');
			$table->foreign('role_id')
					->references('id')
					->on('roles')
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
        Schema::drop('delegues_roles');
    }
}
