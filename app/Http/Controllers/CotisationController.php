<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\Caisse;
use App\Models\Member;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        if (! $user->canManageCotisations()) {
            return redirect()->route('cotisations.index')->with('error', 'Vous n’avez pas la permission de gérer les cotisations.');
        }

        $members = Member::active()->orderBy('nom')->get();
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
        if (! $user->canManageCotisations()) {
            return redirect()->route('cotisations.index')->with('error', 'Vous n’avez pas la permission de gérer les cotisations.');
        }

        $request->validate([
            'member_id'     => 'required|exists:members,id',
            'mois'          => 'required|integer|min:1|max:12',
            'annee'         => 'required|integer|min:2020',
            'montant'       => 'required|numeric|min:0|max:1000',
            'date_paiement' => 'required|date',
        ]);

        // Vérifie si le membre a déjà payé ce mois
        $dejaPaye = Cotisation::where('member_id', $request->member_id)
            ->where('mois', $request->mois)
            ->where('annee', $request->annee)
            ->exists();

        if ($dejaPaye) {
            return back()
                ->withErrors('Ce membre a déjà cotisé pour ce mois.')
                ->withInput();
        }

        $cotisation = DB::transaction(function () use ($request) {
            $cotisation = Cotisation::create($request->only([
                'member_id', 'mois', 'annee', 'montant', 'date_paiement',
            ]));

            Caisse::ajouterMontant((float) $request->montant);

            return $cotisation;
        });

        $member = $cotisation->member;
        AuditLogger::log(
            'created',
            $cotisation,
            'Création de la cotisation de ' . number_format($cotisation->montant, 0, ',', ' ') . ' FCFA pour ' . $member->nom . ' ' . $member->prenoms,
            $member->nom . ' ' . $member->prenoms
        );

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
        /** @var User $user */
        $user = Auth::user();
        if (! $user->canManageCotisations()) {
            return redirect()->route('cotisations.index')->with('error', 'Vous n’avez pas la permission de gérer les cotisations.');
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
        if (! $user->canManageCotisations()) {
            return redirect()->route('cotisations.index')->with('error', 'Vous n’avez pas la permission de gérer les cotisations.');
        }

        $request->validate([
            'mois'          => 'required|integer|min:1|max:12',
            'annee'         => 'required|integer|min:2020',
            'montant'       => 'required|numeric|min:0|max:1000',
            'date_paiement' => 'required|date',
        ]);

        $cotisation = Cotisation::findOrFail($id);

        // Empêcher doublon lors de la modification
        $existe = Cotisation::where('member_id', $cotisation->member_id)
            ->where('mois', $request->mois)
            ->where('annee', $request->annee)
            ->where('id', '!=', $id)
            ->exists();

        if ($existe) {
            return back()->withErrors('Une cotisation existe déjà pour ce mois.');
        }

        $miseAJourEffectuee = DB::transaction(function () use ($cotisation, $request) {
            $difference = (float) $request->montant - (float) $cotisation->montant;

            if ($difference > 0) {
                Caisse::ajouterMontant($difference);
            } elseif ($difference < 0 && ! Caisse::retirerMontant(abs($difference))) {
                return false;
            }

            $cotisation->update($request->only([
                'mois', 'annee', 'montant', 'date_paiement',
            ]));

            return true;
        });

        if (! $miseAJourEffectuee) {
            return back()->withErrors([
                'montant' => 'Le solde de la caisse est insuffisant pour réduire cette cotisation.',
            ])->withInput();
        }

        AuditLogger::log(
            'updated',
            $cotisation,
            'Modification de la cotisation : ' . number_format($cotisation->montant, 0, ',', ' ') . ' FCFA, période ' . $cotisation->mois . '/' . $cotisation->annee,
            $cotisation->member->nom . ' ' . $cotisation->member->prenoms
        );

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
        if (! $user->canManageCotisations()) {
            return redirect()->route('cotisations.index')->with('error', 'Vous n’avez pas la permission de gérer les cotisations.');
        }

        $cotisation = Cotisation::findOrFail($id);
        $suppressionEffectuee = DB::transaction(function () use ($cotisation) {
            if (! Caisse::retirerMontant((float) $cotisation->montant)) {
                return false;
            }

            $cotisation->delete();

            return true;
        });

        if (! $suppressionEffectuee) {
            return back()->withErrors([
                'error' => 'La cotisation ne peut pas être supprimée car son montant n’est plus disponible dans la caisse.',
            ]);
        }

        AuditLogger::log(
            'deleted',
            $cotisation,
            'Suppression de la cotisation de ' . number_format($cotisation->montant, 0, ',', ' ') . ' FCFA, période ' . $cotisation->mois . '/' . $cotisation->annee,
            $cotisation->member->nom . ' ' . $cotisation->member->prenoms
        );

        return back()->with('success', 'Cotisation supprimée');
    }

    /**
     * Calculer les membres sans cotisation pour le mois et l’année sélectionnés
     */
    public function retards(Request $request)
    {
        $mois = (int) $request->integer('mois', now()->month);
        $annee = (int) $request->integer('annee', now()->year);

        $mois = max(1, min(12, $mois));
        $annee = max(2020, $annee);

        $search = trim((string) $request->string('search'));

        $query = Member::active()
            ->whereDoesntHave('cotisations', function ($cotisations) use ($mois, $annee) {
                $cotisations->where('mois', $mois)
                    ->where('annee', $annee);
            });

        if ($search !== '') {
            $query->where(function ($members) use ($search) {
                $members->where('nom', 'like', '%' . $search . '%')
                    ->orWhere('prenoms', 'like', '%' . $search . '%')
                    ->orWhere('numero_membre', 'like', '%' . $search . '%');
            });
        }

        $members = $query->orderBy('nom')->orderBy('prenoms')->paginate(15)->withQueryString();

        $moisNoms = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre',
        ];

        $totalMembres = Member::active()->count();
        $retardsCount = Member::active()->whereDoesntHave('cotisations', function ($cotisations) use ($mois, $annee) {
            $cotisations->where('mois', $mois)->where('annee', $annee);
        })->count();

        return view('cotisations.retards', compact(
            'members',
            'mois',
            'annee',
            'moisNoms',
            'search',
            'totalMembres',
            'retardsCount'
        ));
    }
}
