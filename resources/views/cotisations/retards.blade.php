@extends('layouts.app')

@section('title', 'Membres en retard')

@section('content')
<div class="retards-container">
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"></circle>
                    <line x1="12" y1="7" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                Membres en retard
            </h1>
            <p class="page-subtitle">Suivi des cotisations impayées pour la période : <strong>{{ $moisNoms[$mois] }} {{ $annee }}</strong></p>
        </div>
        <div class="header-actions">
            <span class="badge badge-red" style="padding: 6px 14px; font-size: 13px;">{{ $retardsCount }} membre(s) à relancer</span>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="stats-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 24px;">
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--blue-soft); color: var(--blue);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Effectif total</h3>
                <p class="stat-number">{{ $totalMembres }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: var(--red-soft); color: var(--red);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Membres en retard</h3>
                <p class="stat-number" style="color: var(--red);">{{ $retardsCount }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: var(--green-soft); color: var(--green);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <h3>À jour sur la période</h3>
                <p class="stat-number" style="color: var(--green);">{{ max(0, $totalMembres - $retardsCount) }}</p>
            </div>
        </div>
    </div>

    <!-- Barre de filtres -->
    <form method="GET" action="{{ route('cotisations.retards') }}" class="filters-bar" id="retardsFilters">
        <div class="filter-group">
            <select name="mois" id="retardsMonth" class="form-select filter-select" aria-label="Mois">
                @foreach($moisNoms as $numero => $nom)
                    <option value="{{ $numero }}" {{ $mois === $numero ? 'selected' : '' }}>{{ $nom }}</option>
                @endforeach
            </select>

            <select name="annee" id="retardsYear" class="form-select filter-select" aria-label="Année">
                @foreach(range(now()->year, now()->year - 10) as $year)
                    <option value="{{ $year }}" {{ $annee === $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        </div>

        <div class="search-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="search" name="search" id="retardsSearch" value="{{ $search }}" placeholder="Rechercher par nom, prénom ou numéro..." class="form-control">
        </div>
    </form>

    <!-- Tableau des membres en retard -->
    <div class="table-card">
        <div class="table-header">
            <h3>Liste des fidèles sans règlement</h3>
            <span class="badge badge-red">{{ $members->count() }} résultats affichés</span>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Membre</th>
                        <th>Numéro</th>
                        <th>Profession</th>
                        <th>Statut</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                        <tr>
                            <td>
                                <strong style="color: var(--text-main); font-size: 14px;">{{ $member->nom }} {{ $member->prenoms }}</strong>
                            </td>
                            <td><span class="badge badge-blue">N° {{ $member->numero_membre }}</span></td>
                            <td>{{ $member->profession ?: '—' }}</td>
                            <td><span class="badge badge-red">En retard</span></td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; align-items: center; gap: 8px;">
                                    <a href="{{ route('members.cotisations', $member) }}" class="btn btn-outline btn-sm">Historique</a>
                                    @if(auth()->user()->canManageCotisations())
                                        <a href="{{ route('cotisations.create', ['member_id' => $member->id]) }}" class="btn btn-primary btn-sm">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>
                                            Régulariser
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-row" style="padding: 40px 20px; text-align: center; color: var(--text-muted);">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="40" height="40" style="margin-bottom: 8px; color: var(--green);">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                                <p style="font-weight: 600; color: var(--text-main);">Tous les membres sont à jour !</p>
                                <p style="font-size: 13px;">Aucun membre en retard pour la période de {{ $moisNoms[$mois] }} {{ $annee }}.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
const retardsFilters = document.getElementById('retardsFilters');
const retardsSearch = document.getElementById('retardsSearch');
let retardsTimeout;

retardsFilters?.querySelectorAll('select').forEach(select => {
    select.addEventListener('change', () => retardsFilters.submit());
});

retardsSearch?.addEventListener('input', () => {
    clearTimeout(retardsTimeout);
    retardsTimeout = setTimeout(() => retardsFilters.submit(), 350);
});
</script>
@endpush
@endsection
