<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Disponibilite;

class DisponibilitesBenevoles extends TestCase
{
	use DatabaseTransactions;
	
	/**
	 * @test
	 * Sauvegarder les disponibilités dans une BD
	 */
    public function sauvegarde_d_un_bon_modele()
    {
    	$disponibilite = new disponibilite;
    	$disponibilite->benevole_id = "1";
    	$disponibilite->title = 'test';
    	$disponibilite->isAllDay = "0";
    	$disponibilite->start = "2016-11-27 10:00:00";
    	$disponibilite->end = "2016-11-27 14:00:00";
    	$this->assertTrue($disponibilite->save());
    	$this->seeInDatabase('disponibilites', [
    			'id'=>$disponibilite->id,
    			'benevole_id'=>$disponibilite->benevole_id,
    			'title'=>$disponibilite->title,
    			'isAllDay'=>$disponibilite->isAllDay,
    			'start'=>$disponibilite->start,
    			'end'=>$disponibilite->end
    	]);
    }
}
