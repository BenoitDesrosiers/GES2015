<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;

/**
 * Le controller principal
 * 
 * Il est appeler par la route / 
 * 
 * Il affiche les boutons afin d'accéder aux différentes option du système. 
 * 
 * @author benou
 * @version 0.1
 */
class HomeController extends BaseController {

	/**
	 * La page d'ouverture du site
	 * 
	 * @return Illuminate/Http/Response
	*/

	public function index()
	{
		return View::make('homePage');
	}	

}