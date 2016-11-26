<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactsRequest;
use App\Models\Organisme;
use App\Models\Contact;
use Session;
use View;
use Input;

class ContactsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $organisme = Organisme::findOrFail($id);
        return View::make('contacts.create', compact('organisme'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactsRequest $request, $id)
    {
        $data = $request->all();
        $contact = new Contact();
        $contact->prenom = $data['prenom'];
        $contact->nom = $data['nom'];
        $contact->telephone = $data['telephone'];
        $contact->role = $data['role'];
        $contact->organisme_id = $id;
        $contact->save();
        Session::flash('success_create', 'Le contact a été ajouté avec succès!');
        return redirect()->action('OrganismesController@show', ['id' => $id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($organismeId, $contactId)
    {
        $organisme = Organisme::findOrFail($organismeId);
        $contact = Contact::findOrFail($contactId);
        return View::make('contacts.edit', compact('organisme', 'contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($organismeId, $contactId)
    {
        $contact = Contact::findOrFail($contactId);
        $contact->prenom = Input::get('prenom');
        $contact->nom = Input::get('nom');
        $contact->telephone = Input::get('telephone');
        $contact->role = Input::get('role');

        $contact->save(); //FIXME: bien qu'on soit protégé par le request, ca peut quand même planté au niveau de la BD. Protéger par un try/catch
        Session::flash('success_update', 'Le contact a été modifié avec succès!');
        return redirect()->action('OrganismesController@show', ['id' => $organismeId]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($organismeId, $contactId)
    {
        $contact = Contact::findOrFail($contactId);
        $contact->delete(); //FIXME: proteger par un try/catch et une transaction
        Session::flash('success_delete', 'Le contact a été supprimé avec succès!');
        return redirect()->action('OrganismesController@show', ['id' => $organismeId]);
    }
}
