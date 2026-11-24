@extends('layouts.app')

@section('title', 'Gestion des cotisations')

@section('content')
<div class="cotisations-container">
    <!-- En-tête -->
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                    <line x1="2" y1="10" x2="22" y2="10"></line>
                </svg>
                Gestion des cotisations
            </h1>
            <p class="page-subtitle">Suivez et enregistrez les contributions mensuelles des membres</p>
        </div>
        
        @if(!auth()->user()->canManageCotisations())
            <div class="header-actions">
                <a href="{{ route('cotisations.create') }}" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Nouvelle cotisation
                </a>
            </div>
        @endif
    </div>

    <!-- Filtres -->
    <div class="filters-bar">
        <div class="search-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" placeholder="Rechercher un membre..." id="searchInput">
        </div>
        
        <div class="filter-group">
            <select class="filter-select" id="yearFilter" aria-label="Filtrer par année">
                <option value="">Toutes les années</option>
                @foreach(range(date('Y'), date('Y')-3) as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
            
            <select class="filter-select" id="monthFilter" aria-label="Filtrer par mois">
                <option value="">Tous les mois</option>
                @php
                    $moisNoms = [
                        1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                        5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                        9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                    ];
                @endphp
                @foreach($moisNoms as $num => $nom)
                    <option value="{{ $num }}">{{ $nom }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Carte du tableau -->
    <div class="table-card">
        <div class="table-header">
            <h3>Liste des cotisations</h3>
            <span class="badge badge-blue">{{ $cotisations->count() }} enregistrements</span>
        </div>

        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Membre</th>
                        <th>Période</th>
                        <th>Montant</th>
                        <th>Date paiement</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cotisations as $cotisation)
                        @php
                            $estEnRetard = $cotisation->date_paiement < now()->subMonth();
                            $moisNoms = [
                                1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                                5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                                9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                            ];
                        @endphp
                        <tr class="cotisation-row" data-member="{{ strtolower($cotisation->member->nom . ' ' . $cotisation->member->prenoms) }}">
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    @if($cotisation->member->photo)
                                        <img src="{{ asset('storage/' . $cotisation->member->photo) }}" 
                                             alt="photo" class="photo-container" style="width: 38px; height: 38px;">
                                    @else
                                        <div class="photo-placeholder" style="width: 38px; height: 38px;">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="18" height="18">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <span class="member-name">{{ $cotisation->member->nom }} {{ $cotisation->member->prenoms }}</span><br>
                                        <span style="font-size: 11px; color: var(--text-muted);">N° {{ $cotisation->member->numero_membre }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-blue">
                                    <span class="month">{{ $moisNoms[$cotisation->mois] ?? $cotisation->mois }}</span>
                                    <span class="year">{{ $cotisation->annee }}</span>
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
                                @if($estEnRetard)
                                    <span class="badge badge-red">En retard</span>
                                @else
                                    <span class="badge badge-green">À jour</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions">
                                    @if(!auth()->user()->canManageCotisations())
                                        <a href="{{ route('cotisations.edit', $cotisation->id) }}" 
                                           class="btn-edit" title="Modifier">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                                                <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                                            </svg>
                                        </a>
                                        
                                        <form action="{{ route('cotisations.destroy', $cotisation->id) }}" 
                                              method="POST" class="delete-form" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete" 
                                                    onclick="return confirm('Supprimer cette cotisation ? Cette action est irréversible.')"
                                                    title="Supprimer">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
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
                            <td colspan="6" class="empty-state">
                                <div class="empty-content">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                                        <line x1="2" y1="10" x2="22" y2="10"></line>
                                    </svg>
                                    <h3>Aucune cotisation trouvée</h3>
                                    <p>Commencez par enregistrer la première cotisation</p>
                                    @if(!auth()->user()->canManageCotisations())
                                        <a href="{{ route('cotisations.create') }}" class="btn btn-primary" style="margin-top: 10px;">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>
                                            Nouvelle cotisation
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($cotisations, 'links'))
            <div class="pagination-wrapper">
                {{ $cotisations->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Recherche en temps réel
document.getElementById('searchInput')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.cotisation-row');
    
    rows.forEach(row => {
        const memberName = row.getAttribute('data-member') || '';
        row.style.display = memberName.includes(searchTerm) ? '' : 'none';
    });
});

// Filtres
document.getElementById('yearFilter')?.addEventListener('change', filterTable);
document.getElementById('monthFilter')?.addEventListener('change', filterTable);

function filterTable() {
    const yearFilter = document.getElementById('yearFilter').value;
    const monthFilter = document.getElementById('monthFilter').value;
    const rows = document.querySelectorAll('.cotisation-row');
    
    rows.forEach(row => {
        const year = row.querySelector('.year')?.textContent.trim();
        const month = row.querySelector('.month')?.textContent.trim();
        
        let show = true;
        
        if (yearFilter && year !== yearFilter) show = false;
        if (monthFilter) {
            const moisNoms = [
                'Janvier','Février','Mars','Avril','Mai','Juin',
                'Juillet','Août','Septembre','Octobre','Novembre','Décembre'
            ];
            const expectedMonth = moisNoms[parseInt(monthFilter) - 1];
            if (expectedMonth !== month) show = false;
        }
        
        row.style.display = show ? '' : 'none';
    });
}
</script>
@endpush
@endsection
