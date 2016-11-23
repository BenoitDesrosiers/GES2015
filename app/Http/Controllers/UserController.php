<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use View;

class UserController extends BaseController {
    /**
     * Affichage de tout les usagers
     */
    public function index()
    {
        try{
            $usagers = User::all();
        }catch (ModelNotFoundException $e ) {
            App::abort ( 404 );
        }

        return View::make('usagers.index', compact('usagers'));
    }
}
