@extends('layouts.app')

@section('content')
<div class="member-cotisations-container">
    <!-- En-tête avec informations du membre -->
    <div class="page-header">
        <div class="header-left">
            <a href="{{ route('cotisations.index') }}" class="btn-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Retour aux cotisations
            </a>
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                    <line x1="2" y1="10" x2="22" y2="10"></line>
                </svg>
                Cotisations
            </h1>
        </div>
    </div>

    <!-- Carte profil du membre -->
    <div class="member-profile-card">
        <div class="profile-header">
            <div class="profile-avatar">
                @if($member->photo)
                    <img src="{{ $member->photo_url }}" alt="{{ $member->nom }}">
                @else
                    <div class="avatar-placeholder">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="profile-info">
                <h2 class="profile-name">{{ $member->nom }} {{ $member->prenoms }}</h2>
                <div class="profile-meta">
                    <span class="meta-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="8" r="4"></circle>
                            <path d="M5.8 15.2a8 8 0 0 1 12.4 0"></path>
                        </svg>
                        {{ $member->profession ?? 'Profession non renseignée' }}
                    </span>
                    <span class="meta-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        Membre depuis {{ \Carbon\Carbon::parse($member->created_at)->format('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Statistiques rapides -->
        <div class="profile-stats">
            <div class="stat-item">
                <span class="stat-label">Total cotisations</span>
                <span class="stat-value">{{ $member->cotisations->count() }}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Montant total</span>
                <span class="stat-value">{{ number_format($member->cotisations->sum('montant'), 0, ',', ' ') }} FCFA</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Moyenne/mois</span>
                <span class="stat-value">{{ number_format($member->cotisations->avg('montant') ?? 0, 0, ',', ' ') }} FCFA</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Dernier paiement</span>
                <span class="stat-value">
                    @if($member->cotisations->isNotEmpty())
                        {{ \Carbon\Carbon::parse($member->cotisations->sortByDesc('date_paiement')->first()->date_paiement)->format('d/m/Y') }}
                    @else
                        -
                    @endif
                </span>
            </div>
        </div>
    </div>

    <!-- Résumé annuel -->
    @php
        $cotisationsParAnnee = $member->cotisations->groupBy('annee');
    @endphp
    
    @if($cotisationsParAnnee->isNotEmpty())
        <div class="annual-summary">
            @foreach($cotisationsParAnnee as $annee => $cotisationsAnnee)
                <div class="year-card">
                    <div class="year-header">
                        <h3>Année {{ $annee }}</h3>
                        <span class="year-total">{{ number_format($cotisationsAnnee->sum('montant'), 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="year-progress">
                        @php
                            $moisPayes = $cotisationsAnnee->pluck('mois')->toArray();
                            $moisTotal = range(1, 12);
                            $taux = count($moisPayes) / 12 * 100;
                        @endphp
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $taux }}%"></div>
                        </div>
                        <span class="progress-text">{{ count($moisPayes) }}/12 mois</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Carte du tableau des cotisations -->
    <div class="table-card">
        <div class="table-header">
            <h3>Historique des cotisations</h3>
            <span class="badge">{{ $member->cotisations->count() }} enregistrements</span>
        </div>

        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Période</th>
                        <th>Montant</th>
                        <th>Date de paiement</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($member->cotisations->sortByDesc('date_paiement') as $cotisation)
                        @php
                            $statut = $cotisation->montant >= 1000 ? 'paye' : 'incomplet';
                            $statutText = $cotisation->montant >= 1000 ? 'Payé' : 'Incomplet';
                            
                            $moisNoms = [
                                1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                                5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                                9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                            ];
                        @endphp
                        <tr>
                            <td data-label="Période">
                                <div class="period-display">
                                    <span class="period-month">{{ $moisNoms[$cotisation->mois] ?? $cotisation->mois }}</span>
                                    <span class="period-year">{{ $cotisation->annee }}</span>
                                </div>
                            </td>
                            <td data-label="Montant">
                                <span class="montant-badge {{ $statut === 'paye' ? 'montant-complet' : 'montant-incomplet' }}">
                                    {{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA
                                </span>
                            </td>
                            <td data-label="Date de paiement">
                                <span class="date-badge">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($cotisation->date_paiement)->format('d/m/Y') }}
                                </span>
                            </td>
                            <td data-label="Statut">
                                <span class="statut-badge statut-{{ $statut }}">
                                    {{ $statutText }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-state">
                                <div class="empty-content">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                                        <line x1="2" y1="10" x2="22" y2="10"></line>
                                    </svg>
                                    <h3>Aucune cotisation</h3>
                                    <p>Ce membre n'a pas encore de cotisations enregistrées</p>
                                    @if(!auth()->user()->isAdmin())
                                        <a href="{{ route('cotisations.create', ['member_id' => $member->id]) }}" class="btn-primary">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>
                                            Ajouter une cotisation
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Graphique simplifié des paiements par mois -->
        @if($member->cotisations->isNotEmpty())
            <div class="payment-calendar">
                <h4>Répartition annuelle</h4>
                <div class="months-grid">
                    @foreach(range(1, 12) as $mois)
                        @php
                            $cotisationMois = $member->cotisations
                                ->where('mois', $mois)
                                ->where('annee', date('Y'))
                                ->first();
                            $estPaye = $cotisationMois && $cotisationMois->montant >= 1000;
                            $estPartiel = $cotisationMois && $cotisationMois->montant < 1000;
                        @endphp
                        <div class="month-card 
                            @if($estPaye) month-paid 
                            @elseif($estPartiel) month-partial 
                            @else month-empty 
                            @endif">
                            <span class="month-name">{{ $moisNoms[$mois] }}</span>
                            @if($cotisationMois)
                                <span class="month-amount">{{ number_format($cotisationMois->montant, 0, ',', ' ') }} FCFA</span>
                            @else
                                <span class="month-amount">-</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<style>
/* ===== VARIABLES ===== */
:root {
    --green: #168a4a;
    --green-light: #1e9b54;
    --green-dark: #0f6a38;
    --green-soft: #e8f5e9;
    --blue: #2563eb;
    --yellow: #f59e0b;
    --yellow-soft: #fff3e0;
    --red: #ef4444;
    --red-soft: #fee2e2;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-800: #1f2937;
    --white: #ffffff;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    --shadow-green: 0 4px 6px rgba(22, 138, 74, 0.2);
}

/* ===== CONTAINER PRINCIPAL ===== */
.member-cotisations-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1.5rem;
}

/* ===== HEADER ===== */
.page-header {
    margin-bottom: 2rem;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--white);
    color: var(--gray-600);
    border: 2px solid var(--gray-200);
    border-radius: 0.75rem;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-back:hover {
    background: var(--gray-50);
    border-color: var(--gray-300);
    color: var(--gray-800);
    transform: translateX(-2px);
}

.btn-back svg {
    width: 1.25rem;
    height: 1.25rem;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: var(--gray-800);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin: 0;
}

.page-title .icon {
    width: 2rem;
    height: 2rem;
    color: var(--green);
}

/* ===== BOUTON PRIMAIRE ===== */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    background: var(--green);
    color: white;
    border: none;
    border-radius: 0.75rem;
    font-size: 0.95rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    box-shadow: var(--shadow-green);
    cursor: pointer;
}

.btn-primary:hover {
    background: var(--green-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-primary svg {
    width: 1.25rem;
    height: 1.25rem;
}

/* ===== CARTE PROFIL MEMBRE ===== */
.member-profile-card {
    background: white;
    border-radius: 1.5rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--gray-200);
}

.profile-header {
    display: flex;
    gap: 1.5rem;
    align-items: center;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid var(--green);
    box-shadow: var(--shadow-md);
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder {
    width: 100%;
    height: 100%;
    background: var(--gray-200);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-400);
}

.avatar-placeholder svg {
    width: 40px;
    height: 40px;
}

.profile-info {
    flex: 1;
}

.profile-name {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0 0 0.5rem 0;
}

.profile-meta {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--gray-600);
    background: var(--gray-100);
    padding: 0.5rem 1rem;
    border-radius: 2rem;
}

.meta-item svg {
    width: 1rem;
    height: 1rem;
    color: var(--green);
}

/* ===== STATS RAPIDES ===== */
.profile-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--gray-200);
}

.stat-item {
    text-align: center;
    padding: 1rem;
    background: var(--gray-50);
    border-radius: 1rem;
    transition: all 0.2s ease;
}

.stat-item:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    background: white;
}

.stat-label {
    display: block;
    font-size: 0.75rem;
    color: var(--gray-500);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.5rem;
}

.stat-value {
    display: block;
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--gray-800);
}

/* ===== RÉSUMÉ ANNUEL ===== */
.annual-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.year-card {
    background: white;
    border-radius: 1rem;
    padding: 1rem;
    border: 1px solid var(--gray-200);
    box-shadow: var(--shadow-sm);
}

.year-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
}

.year-header h3 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--gray-700);
    margin: 0;
}

.year-total {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--green);
}

.year-progress {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.progress-bar {
    flex: 1;
    height: 6px;
    background: var(--gray-200);
    border-radius: 3px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: var(--green);
    border-radius: 3px;
    transition: width 0.3s ease;
}

.progress-text {
    font-size: 0.75rem;
    color: var(--gray-600);
}

/* ===== TABLE CARD ===== */
.table-card {
    background: white;
    border-radius: 1.5rem;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    border: 1px solid var(--gray-200);
}

.table-header {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--gray-200);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.table-header h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0;
}

.table-header .badge {
    padding: 0.25rem 0.75rem;
    background: var(--gray-100);
    color: var(--gray-600);
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 500;
}

/* ===== TABLE ===== */
.table-responsive {
    overflow-x: auto;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
}

.modern-table thead th {
    text-align: left;
    padding: 1rem 1.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-500);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background: var(--gray-50);
    border-bottom: 1px solid var(--gray-200);
}

.modern-table tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid var(--gray-200);
}

.modern-table tbody tr:last-child {
    border-bottom: none;
}

.modern-table tbody tr:hover {
    background: var(--gray-50);
}

.modern-table td {
    padding: 1rem 1.5rem;
    color: var(--gray-700);
}

/* ===== PERIOD DISPLAY ===== */
.period-display {
    display: inline-flex;
    flex-direction: column;
    background: var(--gray-100);
    padding: 0.5rem 1rem;
    border-radius: 0.75rem;
}

.period-month {
    font-weight: 600;
    color: var(--gray-700);
}

.period-year {
    font-size: 0.75rem;
    color: var(--gray-500);
}

/* ===== MONTANT BADGES ===== */
.montant-badge {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-weight: 600;
}

.montant-complet {
    background: var(--green-soft);
    color: var(--green-dark);
}

.montant-incomplet {
    background: var(--yellow-soft);
    color: var(--yellow);
}

/* ===== DATE BADGE ===== */
.date-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--gray-100);
    border-radius: 2rem;
    font-size: 0.9rem;
}

.date-badge svg {
    width: 1rem;
    height: 1rem;
    color: var(--gray-500);
}

/* ===== STATUT BADGES ===== */
.statut-badge {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.statut-paye {
    background: var(--green-soft);
    color: var(--green-dark);
}

.statut-incomplet {
    background: var(--yellow-soft);
    color: var(--yellow);
}

/* ===== CALENDRIER DE PAIEMENT ===== */
.payment-calendar {
    padding: 2rem;
    border-top: 1px solid var(--gray-200);
}

.payment-calendar h4 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--gray-700);
    margin: 0 0 1rem 0;
}

.months-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
    gap: 0.75rem;
}

.month-card {
    background: var(--gray-50);
    border-radius: 0.75rem;
    padding: 0.75rem;
    text-align: center;
    border: 1px solid var(--gray-200);
    transition: all 0.2s ease;
}

.month-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.month-paid {
    background: var(--green-soft);
    border-color: var(--green);
}

.month-partial {
    background: var(--yellow-soft);
    border-color: var(--yellow);
}

.month-empty {
    background: var(--gray-50);
    border-color: var(--gray-200);
    opacity: 0.7;
}

.month-name {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--gray-700);
    margin-bottom: 0.25rem;
}

.month-amount {
    display: block;
    font-size: 0.7rem;
    color: var(--gray-500);
}

.month-paid .month-amount {
    color: var(--green-dark);
    font-weight: 500;
}

/* ===== EMPTY STATE ===== */
.empty-state td {
    padding: 4rem 2rem;
}

.empty-content {
    text-align: center;
    max-width: 400px;
    margin: 0 auto;
}

.empty-content svg {
    width: 80px;
    height: 80px;
    color: var(--gray-300);
    margin-bottom: 1.5rem;
}

.empty-content h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--gray-700);
    margin-bottom: 0.5rem;
}

.empty-content p {
    color: var(--gray-500);
    margin-bottom: 1.5rem;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .member-cotisations-container {
        padding: 1rem;
    }

    .header-left {
        flex-direction: column;
        align-items: flex-start;
    }

    .page-title {
        font-size: 1.5rem;
    }

    .profile-header {
        flex-direction: column;
        text-align: center;
    }

    .profile-meta {
        justify-content: center;
    }

    .profile-stats {
        grid-template-columns: 1fr 1fr;
    }

    .modern-table thead {
        display: none;
    }

    .modern-table tbody tr {
        display: block;
        padding: 1rem;
        border: 1px solid var(--gray-200);
        border-radius: 1rem;
        margin-bottom: 1rem;
    }

    .modern-table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border: none;
    }

    .modern-table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: var(--gray-500);
        margin-right: 1rem;
    }

    .months-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .months-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}
</style>
@endsection