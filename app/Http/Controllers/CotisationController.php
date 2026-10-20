<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\Caisse;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('cotisations.index')->with('error', 'Les admins ne peuvent pas ajouter de cotisations.');
        }

        $members = Member::orderBy('nom')->get();
        $memberId = $request->member_id;

        return view('cotisations.create', compact('members', 'memberId'));
    }

    /**
     * Enregistrer une cotisation
     */
    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('cotisations.index')->with('error', 'Les admins ne peuvent pas ajouter de cotisations.');
        }

        $validated = $request->validate([
            'member_id'     => 'required|exists:members,id',
            'mois'          => 'required|integer|min:1|max:12',
            'annee'         => 'required|integer|min:2020',
            'montant'       => 'required|numeric|min:0|max:1000',
            'date_paiement' => 'required|date',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Vérifie si le membre a déjà payé ce mois
                $dejaPaye = Cotisation::where('member_id', $validated['member_id'])
                    ->where('mois', $validated['mois'])
                    ->where('annee', $validated['annee'])
                    ->exists();

                if ($dejaPaye) {
                    throw ValidationException::withMessages([
                        'mois' => 'Ce membre a déjà cotisé pour ce mois.',
                    ]);
                }

                Cotisation::create($validated);
                Caisse::ajouterMontant((float) $validated['montant']);
            });
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

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
     * Formulaire d'édition
     */
    public function edit($id)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('cotisations.index')->with('error', 'Les admins ne peuvent pas modifier les cotisations.');
        }

        $cotisation = Cotisation::with('member')->findOrFail($id);
        return view('cotisations.edit', compact('cotisation'));
    }

    /**
     * Mettre à jour une cotisation
     */
    public function update(Request $request, $id)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('cotisations.index')->with('error', 'Les admins ne peuvent pas modifier les cotisations.');
        }

        $validated = $request->validate([
            'mois'          => 'required|integer|min:1|max:12',
            'annee'         => 'required|integer|min:2020',
            'montant'       => 'required|numeric|min:0|max:1000',
            'date_paiement' => 'required|date',
        ]);

        $cotisation = Cotisation::findOrFail($id);

        try {
            DB::transaction(function () use ($validated, $cotisation, $id) {
                // Empêcher doublon lors de la modification
                $existe = Cotisation::where('member_id', $cotisation->member_id)
                    ->where('mois', $validated['mois'])
                    ->where('annee', $validated['annee'])
                    ->where('id', '!=', $id)
                    ->exists();

                if ($existe) {
                    throw ValidationException::withMessages([
                        'mois' => 'Une cotisation existe déjà pour ce mois.',
                    ]);
                }

                // Ajuster la caisse en fonction de la différence de montant
                $difference = (float) $validated['montant'] - (float) $cotisation->montant;

                if ($difference < 0 && !Caisse::retirerMontant(abs($difference))) {
                    throw ValidationException::withMessages([
                        'montant' => 'Le solde de la caisse est insuffisant pour réduire cette cotisation.',
                    ]);
                }

                if ($difference > 0) {
                    Caisse::ajouterMontant($difference);
                }

                $cotisation->update($validated);
            });
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

        return redirect()
            ->route('cotisations.index')
            ->with('success', 'Cotisation mise à jour');
    }

    /**
     * Supprimer une cotisation
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('cotisations.index')->with('error', 'Les admins ne peuvent pas supprimer les cotisations.');
        }

        $cotisation = Cotisation::findOrFail($id);

        try {
            DB::transaction(function () use ($cotisation) {
                if (!Caisse::retirerMontant((float) $cotisation->montant)) {
                    throw ValidationException::withMessages([
                        'montant' => 'Le solde de la caisse est insuffisant pour annuler cette cotisation.',
                    ]);
                }

                $cotisation->delete();
            });
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }

        return back()->with('success', 'Cotisation supprimée');
    }
}
