<?php

namespace App\Http\Controllers;

use App\Http\Requests\CafeteriaRequest;
use App\Models\Cafeteria;
use App\Models\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

/**
 * Le controller pour les cafétérias
 *
 * @author Alexandre
 */
class CafeteriasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CafeteriaRequest $request)
    {
        try {

            DB::beginTransaction();

            $cafeteria = Cafeteria::create([
                'nom' => $request['nom'],
                'adresse' => $request['adresse'],
                'localisation' => $request['localisation']
            ]);

            $this->sauvegarderResponsables($cafeteria->id, $request['responsable']);

            DB::commit();

        } catch (Exception $e) {
            
            DB::rollBack();
            return redirect('cafeteria')->with('erreur', "Impossible d'enregistrer la cafétéria. Merci de réessayer plus tard.");
        }

        return redirect('cafeterias')->with('status', 'La cafétéria a été ajoutée.');
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
        try {

            $cafeteria = Cafeteria::findOrFail($id);
            $cafeteria->load('responsable');
            return view('cafeterias.edit', compact('cafeteria'));

        } catch (ModelNotFoundException $e) {

            App::abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CafeteriaRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $cafeteria = Cafeteria::findOrFail($id);
            $cafeteria->nom = $request['nom'];
            $cafeteria->adresse = $request['adresse'];
            $cafeteria->localisation = $request['localisation'];
            $cafeteria->save();

            $this->supprimerResponsables($cafeteria);

            $this->sauvegarderResponsables($cafeteria->id, $request['responsable']);

            DB::commit();
            return redirect('cafeterias')->with('status', 'La cafétéria a été modifiée.');

        } catch (ModelNotFoundException $e) {

            DB::rollBack();
            App::abort(404);
        }
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
                
                return redirect()->back()->with('status', 'La cafétéria #' .$id. ' a été supprimée avec succès.');
            
            } catch (Exception $e) {
                DB::rollBack();
            
                return redirect()->back()->with('erreur', 'Une erreur lors de la supression de la cafétéria #' .$id. 'est survenue. Réessayer plus tard.');
            
            }
        }

        return redirect()->back()->with('erreur', "La cafétéria #" .$id. " n'existe pas.");
    }

    /**
     * Supprimer tous les responsables d'une cafétéria.
     * @param  Cafeteria $cafeteria La cafétéria à vider
     */
    private function supprimerResponsables(Cafeteria $cafeteria)
    {
        foreach ($cafeteria->responsable()->get() as $key => $responsable) {
            $responsable->delete();
        }
    }

    /**
     * Sauvegarde des responsables. S'il une clé (nom ou téléphone) est manquante, 
     * le array sera ignoré. 
     * @param  Int    $cafeteria_id l'id de la cafétéria des responsables
     * @param  Array  $responsables Un array contenant des arrays ayant
     *                              une clé nom et une clé téléphone.
     */
    private function sauvegarderResponsables(Int $cafeteria_id, Array $responsables)
    {
        foreach ($responsables as $key => $responsable) {
            if (isset($responsable['nom']) && isset($responsable['telephone'])){
                Responsable::create([
                    'nom' => $responsable['nom'],
                    'telephone' => $responsable['telephone'],
                    'cafeteria_id' => $cafeteria_id,
                ]);
            }
        }
    }

    /**
     * Formate un numéro de téléphone pour l'inscrire dans la base de données.
     * @param  String $numero Le numéro de téléphone
     * @return String         Le numéro formaté.
     */
    private function formaterTelephonePourBD(String $numero)
    {
        $numeroFormatte = str_replace(['(', ')', '-', ' ', '.'], "", $numero);
        return $numeroFormatte;
    }
}
