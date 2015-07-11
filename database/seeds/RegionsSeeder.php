<?php
class RegionsTableSeeder extends Seeder {


	public function run()
	{
		DB::table('regions')->delete();

		$items = [
		//nom, nom_court, url_logo
		["Abitibi-témiscamingue","ABT",""],
		["Bourassa","BOU",""],
		["Capitale-Nationale","CAP",""],
		["Centre-du-Québec","CDQ",""],
		["Chaudière-Appalaches","CHA",""],
		["Côte-Nord","CTN",""],
		["Est-du-Québec","EDQ",""],
		["Estrie","EST",""],
		["Lac-Saint-Louis","LSL",""],
		["Lanaudière","LAN",""],
		["Laurentides","LAU",""],
		["Laval","LAV",""],
		["Mauricie","MAU",""],
		["Montréal","MON",""],
		["Outaouais","OUT",""],
		["Richelieu-Yamaska","RIY",""],
		["Rive-Sud","RIS",""],
		["Saguenay-Lac-Saint-Jean","SLJ",""],
		["Sud-Ouest","SUO",""],
		
		];

		foreach($items as $item) {
			DB::table('regions')->insert(array('nom' => $item[0], 'nom_court'=>$item[1],'url_logo'=>$item[2]));
		}
	}
}