<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactsRequest;
use App\Models\Organisme;
use App\Models\Contact;
use Session;
use View;
use Input;
use App;

class ContactsController extends Controller
{

    /**
     * Affiche la vue pour créer un contact.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $organisme = Organisme::findOrFail($id);
        return View::make('contacts.create', compact('organisme'));
    }

    /**
     * Inscrit un nouveau contact dans la table 'contacts'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(ContactsRequest $request, $id)
    {
        try {
            $data = $request->all();
            $contact = new Contact();
            $contact->prenom = $data['prenom'];
            $contact->nom = $data['nom'];
            $contact->telephone = $data['telephone'];
            $contact->role = $data['role'];
            $contact->organisme_id = $id;
            $contact->save();
            $request->session()->flash('success_create', 'Le contact a été ajouté avec succès!');
            return redirect()->action('OrganismesController@show', ['id' => $id]);
        } catch (Exception $e) {
            App:abort(404);
        }
    }

    /**
     * Affiche la vue pour modifier un contact.
     *
     * @param  int  $organismeId
     * @param  int  $contactId
     * @return \Illuminate\Http\Response
     */
    public function edit($organismeId, $contactId)
    {
        $organisme = Organisme::findOrFail($organismeId);
        $contact = Contact::findOrFail($contactId);
        return View::make('contacts.edit', compact('organisme', 'contact'));
    }

    /**
     * Met à jour le contact choisit dans la table 'contacts'.
     *
     * @param  \App\Http\Requests\ContactsRequest  $request
     * @param  int  $organismeId
     * @param  int  $contactId
     * @return \Illuminate\Http\Response
     */
    public function update(ContactsRequest $request, $organismeId, $contactId)
    {
        try {
            $contact = Contact::findOrFail($contactId);
            $contact->prenom = Input::get('prenom');
            $contact->nom = Input::get('nom');
            $contact->telephone = Input::get('telephone');
            $contact->role = Input::get('role');
            $contact->save();
            $request->session()->flash('success_update', 'Le contact a été modifié avec succès!');
            return redirect()->action('OrganismesController@show', ['id' => $organismeId]);
        } catch (Exception $e) {
            App:abort(404);
        }
    }

    /**
     * Supprime le contact choisit de la table 'contacts'.
     *
     * @param  int  $organismeId
     * @param  int  $contactId
     * @return \Illuminate\Http\Response
     */
    public function destroy($organismeId, $contactId)
    {
        try {
            $contact = Contact::findOrFail($contactId);
            $contact->delete();
            return redirect()->action('OrganismesController@show', ['id' => $organismeId])->with('success_delete', 'Le contact a été supprimé avec succès!');
        } catch (Exception $e) {
            App:abort(404);
        }
    }
}
