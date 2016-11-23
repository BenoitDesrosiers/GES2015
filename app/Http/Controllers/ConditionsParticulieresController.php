<?php

namespace App\Http\Controllers;

use App\Models\ConditionParticuliere;
use Illuminate\Http\Request;
use View;

/**
 * Class ConsitionsParticulieresController
 *
 * Controlleur pour le CRUD des conditions particulières.
 *
 * @author Res260
 * @created_at 161020
 * @modified_at 161020
 * @package App\Http\Controllers
 */
class ConditionsParticulieresController extends Controller
{
	/**
	 * @return \Illuminate\Contracts\View\View La page d'index des conditions particulières.
	 */
	public function index() {
		return View::make('conditionsParticulieres.index',
			['conditionsParticulieres' => ConditionParticuliere::all()]);
	}

	public function show($id) {
		return View::make('conditionsParticulieres.show',
			['condition' => ConditionParticuliere::find($id)]);
	}
}
