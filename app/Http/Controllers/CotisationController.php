<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\Member;
use Illuminate\Http\Request;

class CotisationController extends Controller
{
    /**
     * Liste des cotisations (mois courant par défaut)
     */
    public function index()
    {
        $cotisations = Cotisation::with('member')
            ->orderBy('annee', 'desc')
            ->orderBy('mois', 'desc')
            ->get();

        return view('cotisations.index', compact('cotisations'));
    }

    /**
     * Formulaire d'ajout
     */
    public function create(Request $request)
    {
        $members = Member::orderBy('nom')->get();
        $memberId = $request->membre_id; // correspond à la base

        return view('cotisations.create', compact('members', 'memberId'));
    }

    /**
     * Enregistrer une cotisation
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id'     => 'required|exists:members,id',
            'mois'          => 'required|integer|min:1|max:12',
            'annee'         => 'required|integer|min:2020',
            'montant'       => 'required|numeric|min:0|max:1000',
            'date_paiement' => 'required|date',
        ]);

        // Vérifie si le membre a déjà payé ce mois
        $dejaPaye = Cotisation::where('member_id', $request->membre_id)
            ->where('mois', $request->mois)
            ->where('annee', $request->annee)
            ->exists();

        if ($dejaPaye) {
            return back()
                ->withErrors('Ce membre a déjà cotisé pour ce mois.')
                ->withInput();
        }

        Cotisation::create($request->all());

        return redirect()
            ->route('cotisations.index')
            ->with('success', 'Cotisation enregistrée avec succès');
    }

    /**
     * Afficher les cotisations d’un membre
     */
    public function parMembre(Member $member)
    {
        $cotisations = $member->cotisations() // la relation doit utiliser 'membre_id'
            ->orderBy('annee', 'desc')
            ->orderBy('mois', 'desc')
            ->get();

        return view('cotisations.index', compact('cotisations', 'member'));
    }

    /**
     * Afficher une cotisation spécifique
     */
    public function show($id)
    {
        $member = Member::with('cotisations')->findOrFail($id);
        return view('cotisations.show', compact('member'));
    }

    /**
     * Formulaire d'édition
     */
    public function edit($id)
    {
        $cotisation = Cotisation::with('member')->findOrFail($id);
        return view('cotisations.edit', compact('cotisation'));
    }

    /**
     * Mettre à jour une cotisation
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'mois'          => 'required|integer|min:1|max:12',
            'annee'         => 'required|integer|min:2020',
            'montant'       => 'required|numeric|min:0|max:1000',
            'date_paiement' => 'required|date',
        ]);

        $cotisation = Cotisation::findOrFail($id);

        // Empêcher doublon lors de la modification
        $existe = Cotisation::where('member_id', $cotisation->membre_id)
            ->where('mois', $request->mois)
            ->where('annee', $request->annee)
            ->where('id', '!=', $id)
            ->exists();

        if ($existe) {
            return back()->withErrors('Une cotisation existe déjà pour ce mois.');
        }

        $cotisation->update($request->all());

        return redirect()
            ->route('cotisations.index')
            ->with('success', 'Cotisation mise à jour');
    }

    /**
     * Supprimer une cotisation
     */
    public function destroy($id)
    {
        $cotisation = Cotisation::findOrFail($id);
        $cotisation->delete();

        return back()->with('success', 'Cotisation supprimée');
    }
}
