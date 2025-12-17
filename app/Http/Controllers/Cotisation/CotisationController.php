<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\Member;
use App\Models\Membre;
use Illuminate\Http\Request;

class CotisationController extends Controller
{
    /**
     * Liste des cotisations (mois courant par défaut)
     */
    public function index()
    {
        $cotisations = Cotisation::with('membre')
            ->orderBy('annee', 'desc')
            ->orderBy('mois', 'desc')
            ->get();

        return view('cotisations.index', compact('cotisations'));
    }

    /**
     * Formulaire d'ajout
     */
    public function create()
    {
        $membres = Member::orderBy('nom')->get();
        return view('cotisations.create', compact('membres'));
    }

    /**
     * Enregistrer une cotisation
     */
    public function store(Request $request)
    {
        $request->validate([
            'membre_id'     => 'required|exists:membres,id',
            'mois'          => 'required|integer|min:1|max:12',
            'annee'         => 'required|integer|min:2020',
            'montant'       => 'required|numeric|min:0|max:1000',
            'date_paiement' => 'required|date',
        ]);

        // Vérifie si le membre a déjà payé ce mois
        $dejaPaye = Cotisation::where('membre_id', $request->membre_id)
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
    public function show($id)
    {
        $membre = Member::with('cotisations')->findOrFail($id);
        return view('cotisations.show', compact('membre'));
    }

    public function edit($id)
    {
        $cotisation = Cotisation::with('membre')->findOrFail($id);
        return view('cotisations.edit', compact('cotisation'));
    }

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
        $existe = Cotisation::where('membre_id', $cotisation->membre_id)
            ->where('mois', $request->mois)
            ->where('annee', $request->annee)
            ->where('id', '!=', $id)
            ->exists();

        if ($existe) {
            return back()->withErrors(
                'Une cotisation existe déjà pour ce mois.'
            );
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
