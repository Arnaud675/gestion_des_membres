@extends('layouts.app')

@section('title', 'Historique des cotisations du membre')

@section('content')
<div class="member-cotisations-container">
    <!-- En-tête -->
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
                Cotisations du membre
            </h1>
            <p class="page-subtitle">Suivi complet des versements pour ce fidèle</p>
        </div>
        <div class="header-actions">
            @if(auth()->user()->canManageCotisations())
                <a href="{{ route('cotisations.create', ['member_id' => $member->id]) }}" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Enregistrer une cotisation
                </a>
            @endif
        </div>
    </div>

    <!-- Carte profil du membre -->
    <div class="member-profile-card">
        <div class="profile-header">
            <div class="profile-avatar">
                @if($member->photo)
                    <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->nom }}" class="photo-container" style="width: 72px; height: 72px;">
                @else
                    <div class="avatar-placeholder" style="width: 72px; height: 72px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="36" height="36">
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
                        <span class="badge badge-blue">N° {{ $member->numero_membre }}</span>
                    </span>
                    <span class="meta-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                        {{ $member->profession ?? 'Profession non renseignée' }}
                    </span>
                    <span class="meta-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                        </svg>
                        Inscrit le {{ \Carbon\Carbon::parse($member->created_at)->format('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Statistiques rapides -->
        <div class="profile-stats">
            <div class="stat-card" style="padding: 16px; flex-direction: column; text-align: center;">
                <span style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Total versements</span>
                <span class="stat-number">{{ $member->cotisations->count() }}</span>
            </div>
            <div class="stat-card" style="padding: 16px; flex-direction: column; text-align: center;">
                <span style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Montant cumulé</span>
                <span class="stat-number" style="color: var(--green);">{{ number_format($member->cotisations->sum('montant'), 0, ',', ' ') }} FCFA</span>
            </div>
            <div class="stat-card" style="padding: 16px; flex-direction: column; text-align: center;">
                <span style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Moyenne/mois</span>
                <span class="stat-number">{{ number_format($member->cotisations->avg('montant') ?? 0, 0, ',', ' ') }} FCFA</span>
            </div>
            <div class="stat-card" style="padding: 16px; flex-direction: column; text-align: center;">
                <span style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Dernier paiement</span>
                <span class="stat-number" style="font-size: 18px;">
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
                            $taux = count($moisPayes) / 12 * 100;
                        @endphp
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $taux }}%"></div>
                        </div>
                        <span class="progress-text">{{ count($moisPayes) }}/12 mois à jour</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Carte du tableau des cotisations -->
    <div class="table-card">
        <div class="table-header">
            <h3>Historique des cotisations</h3>
            <span class="badge badge-blue">{{ $member->cotisations->count() }} enregistrements</span>
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
                            $moisNoms = [
                                1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                                5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                                9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                            ];
                        @endphp
                        <tr>
                            <td>
                                <span class="badge badge-blue">
                                    {{ $moisNoms[$cotisation->mois] ?? $cotisation->mois }} {{ $cotisation->annee }}
                                </span>
                            </td>
                            <td>
                                <strong>{{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA</strong>
                            </td>
                            <td>
                                <span class="date-badge">
                                    {{ \Carbon\Carbon::parse($cotisation->date_paiement)->format('d/m/Y') }}
                                </span>
                            </td>
                            <td>
                                @if($cotisation->montant >= 1000)
                                    <span class="badge badge-green">Complet</span>
                                @else
                                    <span class="badge badge-yellow">Partiel</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-row">Aucune cotisation enregistrée pour ce membre.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
