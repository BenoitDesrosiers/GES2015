<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateEpreuveParticipantTable extends Migration {
	
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'epreuve_participant', function (Blueprint $table) {
			$table->unsignedInteger ( 'participant_id' );
			$table->unsignedInteger ( 'epreuve_id' );
			$table->foreign ( 'participant_id' )->references ( 'id' )->on ( 'participants' )->onDelete ( 'cascade' )->onUpdate ( 'cascade' );
			$table->foreign ( 'epreuve_id' )->references ( 'id' )->on ( 'epreuves' )->onDelete ( 'cascade' )->onUpdate ( 'cascade' );
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop ( 'epreuve_participant' );
	}
}
