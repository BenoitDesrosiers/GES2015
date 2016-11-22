<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeleguesRolesPourDeleguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delegues_roles_pour_delegues', function (Blueprint $table) {
            $table->unsignedInteger('delegue_id');
            $table->unsignedInteger('role_pour_delegue_id');
            $table->foreign('delegue_id')
                ->references('id')
                ->on('delegues')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('role_pour_delegue_id')
                ->references('id')
                ->on('roles_pour_delegues')
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
        Schema::drop('delegues_roles_pour_delegues');
    }
}
