<?php

namespace App\Http\Controllers;

use App\Http\Requests\CafeteriaRequest;
use App\Models\Cafeteria;
use App\Models\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CafeteriasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(phpinfo());
        $cafeterias = Cafeteria::all()->sortBy('nom');
        return view('cafeterias.index', compact('cafeterias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cafeterias.create');
    }

    /**
     * Store a newly created resource in storage.
     * TODO: Valider et formatter les numéros de téléphone.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CafeteriaRequest $request)
    {
        //dd(Input::all());
        $cafeteria = Cafeteria::create([
            'nom' => $request['nom'],
            'adresse' => $request['adresse'],
            'localisation' => $request['localisation']
        ]);

        $responsables = array_map(null, $request['responsableNom'], $request['responsableTelephone']);

        foreach ($responsables as $key => $value) {
            $nom = $value[0];
            $telephone = $value[1];
            
            // Si les deux champs sont remplis.
            if (!(empty($nom) || empty($telephone))){
                $responsable = Responsable::create([
                    'nom' => $value[0],
                    'telephone' => $value[1],
                ]);
                $responsable->cafeteria()->associate($cafeteria);
                $responsable->save();
            }
        }

        return redirect('cafeterias')->with('status', 'La cafétéria a été ajouté.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {

            $cafeteria = Cafeteria::findOrFail($id);
            $cafeteria->load('responsable');
            return view('cafeterias.show', compact('cafeteria'));

        } catch (ModelNotFoundException $e) {

            App::abort(404);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd('edit #' . $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (isset($id)){
            try {

                DB::beginTransaction();

                $responsables = Responsable::where('cafeteria_id', $id)->get();
                foreach ($responsables as $key => $value) {
                    $value->delete();
                }

                $cafeteria = Cafeteria::findOrFail($id);
                $cafeteria->delete();
                
                DB::commit();
                
                return redirect()->back()->with('status', 'La cafétéria #' .$id. ' a été supprimé avec succès.');
            
            } catch (Exception $e) {
                DB::rollBack();
            
                return redirect()->back()->with('erreur', 'Une erreur lors de la supression de la cafétéria #' .$id. 'est survenue. Réessayer plus tard.');
            
            }

        }

        return redirect()->back()->with('erreur', "La cafétéria #" .$id. " n'existe pas.");
    }
}
