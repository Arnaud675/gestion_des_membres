@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="admin-dashboard">
    <!-- En-tête du dashboard -->
    <div class="dashboard-header-card">
        <div class="header-content">
            <div class="header-left">
                <div class="welcome-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Tableau de bord</span>
                </div>
                <h1 class="dashboard-title">
                    <span>Bienvenue, {{ auth()->user()->name }}</span>
                </h1>
                <p class="dashboard-date">{{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</p>
            </div>
            
            <div class="header-right">
                <span class="admin-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                        <path d="M2 17l10 5 10-5"></path>
                        <path d="M2 12l10 5 10-5"></path>
                    </svg>
                    {{ auth()->user()->isAdmin() ? 'Administrateur' : (auth()->user()->isManager() ? 'Gestionnaire' : 'Consultation') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--blue-soft); color: var(--blue);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total membres</h3>
                <p class="stat-number">{{ $totalMembres }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: var(--green-soft); color: var(--green);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                    <line x1="2" y1="10" x2="22" y2="10"></line>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Cotisations</h3>
                <p class="stat-number">{{ $totalCotisations }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: var(--yellow-soft); color: var(--yellow-dark);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 6v6l4 2"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Montant total</h3>
                <p class="stat-number">{{ number_format($montantTotal, 0, ',', ' ') }} FCFA</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: var(--red-soft); color: var(--red);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4"></circle>
                    <path d="M5.8 15.2a8 8 0 0 1 12.4 0"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Nouveaux ce mois</h3>
                <p class="stat-number">{{ $nouveauxMembres }}</p>
            </div>
        </div>
    </div>

    <!-- Actions rapides et aperçus -->
    <div class="dashboard-grid">
        <!-- Section Actions rapides -->
        <div class="dashboard-card actions-card">
            <div class="card-header">
                <h2>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    Actions rapides
                </h2>
                <span class="badge badge-blue">Raccourcis</span>
            </div>
            
            <div class="actions-grid">
                @if(auth()->user()->canManageMembers())
                    <a href="{{ route('members.create') }}" class="action-item">
                        <span class="action-icon" style="background: var(--green); color: white;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </span>
                        <span class="action-label">Ajouter un membre</span>
                        <span class="action-arrow">→</span>
                    </a>
                @endif

                <a href="{{ route('cotisations.index') }}" class="action-item">
                    <span class="action-icon" style="background: var(--yellow-dark); color: white;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <line x1="2" y1="10" x2="22" y2="10"></line>
                        </svg>
                    </span>
                    <span class="action-label">Gérer les cotisations</span>
                    <span class="action-arrow">→</span>
                </a>

                <a href="{{ route('members.index') }}" class="action-item">
                    <span class="action-icon" style="background: var(--blue); color: white;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                        </svg>
                    </span>
                    <span class="action-label">Liste des membres</span>
                    <span class="action-arrow">→</span>
                </a>

                <a href="{{ route('depenses.index') }}" class="action-item">
                    <span class="action-icon" style="background: var(--red); color: white;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                        </svg>
                    </span>
                    <span class="action-label">Gérer les dépenses</span>
                    <span class="action-arrow">→</span>
                </a>
            </div>
        </div>

        <!-- Section Aperçu des dernières activités -->
        <div class="dashboard-card activities-card">
            <div class="card-header">
                <h2>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                    </svg>
                    Dernières activités
                </h2>
                <span class="badge badge-green">En direct</span>
            </div>
            
            <div class="activities-list">
                @forelse($recentActivities as $activity)
                    <div class="activity-item">
                        <div class="activity-dot" style="background: {{ $activity['color'] }};"></div>
                        <div class="activity-content">
                            <p class="activity-text">{{ $activity['text'] }}</p>
                            <p class="activity-time">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                @empty
                    <div class="activity-item">
                        <div class="activity-content">
                            <p class="activity-text">Aucune activité récente</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Graphique réel des cotisations par mois -->
    <div class="dashboard-card chart-card">
        <div class="card-header">
            <h2>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
                Évolution des cotisations
            </h2>
            <div class="chart-controls">
                <select id="chartYearSelect" class="chart-select">
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
                <button id="refreshChart" class="chart-refresh" title="Actualiser" aria-label="Actualiser">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M23 4v6h-6"></path>
                        <path d="M1 20v-6h6"></path>
                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="chart-container">
            <div class="chart-bars" id="chartBars">
                @php
                    $maxMontant = !empty($cotisationsParMois) ? max($cotisationsParMois) : 1;
                    $moisNoms = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                @endphp
                
                @foreach($moisNoms as $index => $nomMois)
                    @php
                        $montant = $cotisationsParMois[$index + 1] ?? 0;
                        $pourcentage = $maxMontant > 0 ? ($montant / $maxMontant) * 100 : 0;
                        $hauteur = $pourcentage * 1.5; // Max 150px
                        $couleur = $montant > 0 ? 'var(--blue)' : 'var(--border-color)';
                    @endphp
                    <div class="chart-bar-item" data-montant="{{ $montant }}" data-mois="{{ $nomMois }}">
                        <div class="bar-container">
                            <div class="bar" style="height: {{ $hauteur }}px; background: {{ $couleur }};"></div>
                        </div>
                        <span class="bar-label">{{ substr($nomMois, 0, 3) }}</span>
                        <div class="bar-tooltip">
                            <strong>{{ $nomMois }} {{ $selectedYear }}</strong><br>
                            {{ number_format($montant, 0, ',', ' ') }} FCFA
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Légende et résumé -->
        <div class="chart-footer">
            <div class="chart-legend">
                <div class="legend-item">
                    <span class="legend-color" style="background: var(--blue);"></span>
                    <span>Cotisations enregistrées</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background: var(--border-color);"></span>
                    <span>Aucune cotisation</span>
                </div>
            </div>
            <div class="chart-summary">
                <div class="summary-stat">
                    <span class="stat-label">Total annuel</span>
                    <span class="stat-value">{{ number_format(array_sum($cotisationsParMois), 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="summary-stat">
                    <span class="stat-label">Moyenne mensuelle</span>
                    <span class="stat-value">{{ number_format(empty($cotisationsParMois) ? 0 : array_sum($cotisationsParMois) / 12, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="summary-stat">
                    <span class="stat-label">Mois le plus élevé</span>
                    <span class="stat-value">{{ $meilleurMois['nom'] ?? '-' }} {{ number_format($meilleurMois['montant'] ?? 0, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const yearSelect = document.getElementById('chartYearSelect');
    const refreshBtn = document.getElementById('refreshChart');
    const chartBars = document.getElementById('chartBars');
    
    // Animation initiale des barres
    animateBars();
    
    function animateBars() {
        const bars = document.querySelectorAll('.bar');
        bars.forEach(bar => {
            const height = bar.style.height;
            bar.style.height = '0';
            setTimeout(() => {
                bar.style.height = height;
            }, 100);
        });
    }
    
    // Changement d'année
    if (yearSelect) {
        yearSelect.addEventListener('change', function() {
            const year = this.value;
            window.location.href = '{{ route("admin.dashboard") }}?year=' + year;
        });
    }
    
    // Bouton d'actualisation
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function() {
            this.style.transform = 'rotate(180deg)';
            setTimeout(() => {
                location.reload();
            }, 300);
        });
    }
    
    // Tooltips au survol
    const barItems = document.querySelectorAll('.chart-bar-item');
    barItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            const tooltip = this.querySelector('.bar-tooltip');
            if (tooltip) {
                tooltip.style.display = 'block';
            }
        });
        
        item.addEventListener('mouseleave', function() {
            const tooltip = this.querySelector('.bar-tooltip');
            if (tooltip) {
                tooltip.style.display = 'none';
            }
        });
    });
});
</script>
@endpush
@endsection
