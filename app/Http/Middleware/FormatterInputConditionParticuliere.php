<?php

namespace App\Http\Middleware;

use Closure;
use Input;

/**
 * Class FormatterInputConditionParticuliere
 *
 * Fait un trim sur l'input reçu pour la
 * condition particulière envoyée.
 *
 * @author Res260
 * @created_at 163429
 * @modified_at 163429
 */
class FormatterInputConditionParticuliere
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	Input::replace(array_map('trim', Input::all()));
        return $next($request);
    }
}
