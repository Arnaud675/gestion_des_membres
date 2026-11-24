@extends('layouts.app')

@section('title', 'Gestion des dépenses')

@section('content')
<div class="depenses-container">
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                </svg>
                Gestion des dépenses
            </h1>
            <p class="page-subtitle">Suivez les dépenses effectuées depuis la caisse globale de l'église</p>
        </div>
        
        @if(auth()->user()->canManageDepenses())
            <div class="header-actions">
                <a href="{{ route('depenses.create') }}" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Nouvelle dépense
                </a>
            </div>
        @endif
    </div>

    <!-- Cartes statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--blue-soft); color: var(--blue);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                    <line x1="2" y1="10" x2="22" y2="10"></line>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total cotisations</h3>
                <p class="stat-number">{{ number_format($stats['total_cotisations'], 0, ',', ' ') }} FCFA</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--red-soft); color: var(--red);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total dépenses</h3>
                <p class="stat-number">{{ number_format($stats['total_depenses'], 0, ',', ' ') }} FCFA</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--green-soft); color: var(--green);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="1" x2="12" y2="23"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Solde disponible</h3>
                <p class="stat-number {{ $stats['solde_global'] < 0 ? 'text-danger' : '' }}" style="color: {{ $stats['solde_global'] < 0 ? 'var(--red)' : 'var(--green-dark)' }};">
                    {{ number_format($stats['solde_global'], 0, ',', ' ') }} FCFA
                </p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--yellow-soft); color: var(--yellow-dark);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Nombre dépenses</h3>
                <p class="stat-number">{{ $depenses->total() }}</p>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filters-bar">
        <div class="search-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" placeholder="Rechercher une dépense..." id="searchInput">
        </div>
        
        <div class="filter-group">
            <select name="type_evenement" id="typeFilter" class="filter-select" aria-label="Filtrer par type">
                <option value="">Tous les types d'événement</option>
                @foreach($typesEvenements as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            
            <select name="member_id" id="memberFilter" class="filter-select" aria-label="Filtrer par membre">
                <option value="">Tous les membres</option>
                @foreach($members as $member)
                    <option value="{{ $member->id }}">{{ $member->nom }} {{ $member->prenoms }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Tableau -->
    <div class="table-card">
        <div class="table-header">
            <h3>Historique des dépenses</h3>
            <span class="badge badge-blue">{{ $depenses->total() }} enregistrées</span>
        </div>

        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Membre concerné</th>
                        <th>Type d'événement</th>
                        <th>Montant</th>
                        <th>Date dépense</th>
                        <th>Enregistré par</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($depenses as $depense)
                        <tr>
                            <td>
                                <span class="ref-badge">{{ $depense->reference }}</span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    @if($depense->member->photo)
                                        <img src="{{ asset('storage/' . $depense->member->photo) }}" class="photo-container" style="width: 34px; height: 34px;">
                                    @else
                                        <div class="photo-placeholder" style="width: 34px; height: 34px;">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                        </div>
                                    @endif
                                    <span class="member-name">{{ $depense->member->nom }} {{ $depense->member->prenoms }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-yellow">
                                    {{ $depense->type_evenement_label }}
                                </span>
                            </td>
                            <td>
                                <strong>{{ number_format($depense->montant, 0, ',', ' ') }} FCFA</strong>
                            </td>
                            <td>
                                <span class="date-badge">
                                    {{ \Carbon\Carbon::parse($depense->date_depense)->format('d/m/Y') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-blue">{{ $depense->createur->name }}</span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('depenses.show', $depense) }}" class="btn-view" title="Voir les détails">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="3"></circle>
                                            <path d="M22 12c-2.667 4.667-6 7-10 7s-7.333-2.333-10-7c2.667-4.667 6-7 10-7s7.333 2.333 10 7z"></path>
                                        </svg>
                                    </a>
                                    @if(auth()->user()->canManageDepenses())
                                        <a href="{{ route('depenses.edit', $depense) }}" class="btn-edit" title="Modifier">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                                                <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                                            </svg>
                                        </a>
                                        <form action="{{ route('depenses.destroy', $depense) }}" method="POST" class="delete-form" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete" onclick="return confirm('Supprimer cette dépense ?')" title="Supprimer">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <div class="empty-content">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                    </svg>
                                    <h3>Aucune dépense enregistrée</h3>
                                    <p>Commencez par enregistrer la première dépense</p>
                                    @if(auth()->user()->canManageDepenses())
                                        <a href="{{ route('depenses.create') }}" class="btn btn-primary" style="margin-top: 10px;">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>
                                            Nouvelle dépense
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($depenses, 'links'))
            <div class="pagination-wrapper">
                {{ $depenses->links() }}
            </div>
        @endif
    </div>

    <!-- Répartition des dépenses par type -->
    @if(!empty($depensesParType))
        <div class="repartition-card">
            <div class="card-header">
                <h2>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    Répartition par événement
                </h2>
            </div>
            <div class="repartition-grid">
                @php
                    $colors = ['var(--blue)', 'var(--green)', 'var(--yellow-dark)', 'var(--red)'];
                    $i = 0;
                @endphp
                @foreach($depensesParType as $type => $total)
                    @php
                        $percentage = $stats['total_depenses'] > 0 ? ($total / $stats['total_depenses']) * 100 : 0;
                        $color = $colors[$i % count($colors)];
                    @endphp
                    <div class="repartition-item">
                        <div class="repartition-header">
                            <span class="repartition-label">{{ $typesEvenements[$type] ?? ucfirst($type) }}</span>
                            <span class="repartition-amount">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="progress-bar-container">
                            <div style="flex: 1; height: 8px; background: #f1f5f9; border-radius: 9999px; overflow: hidden;">
                                <div class="progress-bar-fill" style="width: {{ $percentage }}%; background: {{ $color }}; height: 100%;"></div>
                            </div>
                            <span class="progress-percentage">{{ round($percentage) }}%</span>
                        </div>
                    </div>
                    @php $i++; @endphp
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.getElementById('searchInput')?.addEventListener('input', function(e) {
    const term = e.target.value.toLowerCase();
    document.querySelectorAll('.modern-table tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
    });
});

document.getElementById('typeFilter')?.addEventListener('change', filterTable);
document.getElementById('memberFilter')?.addEventListener('change', filterTable);

function filterTable() {
    const type = document.getElementById('typeFilter').value;
    const member = document.getElementById('memberFilter').value;
    document.querySelectorAll('.modern-table tbody tr').forEach(row => {
        let show = true;
        if (type && !row.textContent.includes(type)) show = false;
        if (member && !row.textContent.includes(member)) show = false;
        row.style.display = show ? '' : 'none';
    });
}
</script>
@endpush
@endsection
