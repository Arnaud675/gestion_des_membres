<?php
// app/Http/Controllers/DepenseController.php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\Member;
use App\Models\Caisse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DepenseController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Liste des dépenses
     */
    public function index(Request $request)
    {
        $query = Depense::with(['member', 'createur']);

        if ($request->filled('type_evenement')) {
            $query->ofType($request->type_evenement);
        }

        if ($request->filled('member_id')) {
            $query->where('member_id', $request->member_id);
        }

        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->dateBetween($request->date_debut, $request->date_fin);
        }

        $depenses = $query->orderBy('date_depense', 'desc')
                         ->orderBy('created_at', 'desc')
                         ->paginate(15);

        // Statistiques globales
        $totalCotisations = DB::table('cotisations')->sum('montant') ?? 0;
        $totalDepenses = Depense::sum('montant') ?? 0;
        $soldeGlobal = Caisse::getSoldeGlobal();

        $stats = [
            'total_cotisations' => $totalCotisations,
            'total_depenses' => $totalDepenses,
            'solde_global' => $soldeGlobal,
            'depenses_par_type' => Depense::select('type_evenement', DB::raw('SUM(montant) as total'))
                                        ->groupBy('type_evenement')
                                        ->get()
        ];

        $members = Member::orderBy('nom')->get();
        $typesEvenements = Depense::TYPES_EVENEMENTS;

        return view('depenses.index', compact('depenses', 'stats', 'members', 'typesEvenements'));
    }

    /**
     * Formulaire de création
     */
    public function create(Request $request)
    {
        $members = Member::orderBy('nom')->get();
        $typesEvenements = Depense::TYPES_EVENEMENTS;
        $soldeGlobal = Caisse::getSoldeGlobal();
        $selectedMember = $request->member_id ? Member::find($request->member_id) : null;

        return view('depenses.create', compact('members', 'typesEvenements', 'soldeGlobal', 'selectedMember'));
    }

    /**
     * Enregistrement d'une dépense
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'type_evenement' => 'required|in:' . implode(',', array_keys(Depense::TYPES_EVENEMENTS)),
            'montant' => 'required|numeric|min:1|max:100000000',
            'date_depense' => 'required|date|before_or_equal:today',
            'description' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            // Vérifier le solde global
            $soldeGlobal = Caisse::getSoldeGlobal();
            if ($soldeGlobal < $validated['montant']) {
                return back()->withErrors([
                    'montant' => 'Solde global insuffisant. Solde disponible : ' . number_format($soldeGlobal, 0, ',', ' ') . ' FCFA'
                ])->withInput();
            }

            // Créer la dépense
            $depense = Depense::create([
                'member_id' => $validated['member_id'],
                'type_evenement' => $validated['type_evenement'],
                'montant' => $validated['montant'],
                'date_depense' => $validated['date_depense'],
                'description' => $validated['description'] ?? null,
                'created_by' => Auth::id()
            ]);

            // Déduire du solde global
            Caisse::retirerMontant($validated['montant']);

            DB::commit();

            return redirect()->route('depenses.show', $depense)
                            ->with('success', 'Dépense enregistrée avec succès. Référence : ' . $depense->reference);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Détails d'une dépense
     */
    public function show(Depense $depense)
    {
        $depense->load(['member', 'createur']);
        $soldeGlobal = Caisse::getSoldeGlobal();
        
        return view('depenses.show', compact('depense', 'soldeGlobal'));
    }

    /**
     * Formulaire de modification
     */
    public function edit(Depense $depense)
    {
        $members = Member::orderBy('nom')->get();
        $typesEvenements = Depense::TYPES_EVENEMENTS;
        $soldeGlobal = Caisse::getSoldeGlobal();
        
        // Solde après annulation de cette dépense (comme si elle n'existait pas)
        $soldeSansCetteDepense = $soldeGlobal + $depense->montant;
        
        return view('depenses.edit', compact('depense', 'members', 'typesEvenements', 'soldeGlobal', 'soldeSansCetteDepense'));
    }

    /**
     * Mise à jour d'une dépense
     */
    public function update(Request $request, Depense $depense)
    {
        $validated = $request->validate([
            'type_evenement' => 'required|in:' . implode(',', array_keys(Depense::TYPES_EVENEMENTS)),
            'montant' => 'required|numeric|min:1|max:100000000',
            'date_depense' => 'required|date|before_or_equal:today',
            'description' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $soldeGlobal = Caisse::getSoldeGlobal();
            $difference = $validated['montant'] - $depense->montant;
            
            // Si le nouveau montant est plus élevé, vérifier le solde
            if ($difference > 0 && $soldeGlobal < $difference) {
                return back()->withErrors([
                    'montant' => 'Solde global insuffisant pour cette augmentation. Solde disponible : ' . number_format($soldeGlobal, 0, ',', ' ') . ' FCFA'
                ])->withInput();
            }

            // Mettre à jour la dépense
            $depense->update($validated);

            // Ajuster le solde global
            if ($difference != 0) {
                if ($difference > 0) {
                    Caisse::retirerMontant($difference);
                } else {
                    Caisse::ajouterMontant(abs($difference));
                }
            }

            DB::commit();

            return redirect()->route('depenses.show', $depense)
                            ->with('success', 'Dépense modifiée avec succès');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Une erreur est survenue'])->withInput();
        }
    }

    /**
     * Suppression d'une dépense
     */
    public function destroy(Depense $depense)
    {
        try {
            DB::beginTransaction();
            
            // Rétablir le montant dans le solde global
            Caisse::ajouterMontant($depense->montant);
            
            $depense->delete();

            DB::commit();

            return redirect()->route('depenses.index')
                            ->with('success', 'Dépense supprimée avec succès');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la suppression']);
        }
    }
}