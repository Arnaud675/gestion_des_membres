@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="admin-dashboard">
    <!-- Éléments décoratifs -->
    <div class="dashboard-bg decoration-1"></div>
    <div class="dashboard-bg decoration-2"></div>
    
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
                    
                    <span style="font-size: 30px" class="user-name">{{ auth()->user()->name }}</span>
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
                    Administrateur
                </span>
            </div>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(31, 79, 216, 0.1); color: var(--blue);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total membres</h3>
                <p class="stat-number">{{ \App\Models\Member::count() }}</p>
                <span class="stat-trend positive">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="18 15 12 9 6 15"></polyline>
                    </svg>
                    {{-- +12% ce mois --}}
                </span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(31, 168, 91, 0.1); color: var(--green);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                    <line x1="2" y1="10" x2="22" y2="10"></line>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Cotisations</h3>
                <p class="stat-number">{{ \App\Models\Cotisation::count() }}</p>
                <span class="stat-trend positive">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="18 15 12 9 6 15"></polyline>
                    </svg>
                    {{-- +8% ce mois --}}
                </span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(242, 194, 0, 0.1); color: var(--yellow);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 6v6l4 2"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Montant total</h3>
                <p class="stat-number">{{ number_format(\App\Models\Cotisation::sum('montant'), 0, ',', ' ') }} FCFA</p>
                {{-- <span class="stat-trend">Ce mois</span> --}}
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(214, 40, 40, 0.1); color: var(--red);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4"></circle>
                    <path d="M5.8 15.2a8 8 0 0 1 12.4 0"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Nouveaux</h3>
                <p class="stat-number">{{ \App\Models\Member::whereMonth('created_at', now()->month)->count() }}</p>
                <span class="stat-trend">Ce mois</span>
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
                <span class="badge">Menu</span>
            </div>
            
            <div class="actions-grid">
                @if (!auth()->user()->isAdmin())
                    <a href="{{ route('members.create') }}" class="action-item">
                        <span class="action-icon" style="background: var(--green);">
                            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </span>
                        <span class="action-label">Ajouter un membre</span>
                        <span class="action-arrow">→</span>
                    </a>
                @endif

                <a href="{{ route('cotisations.index') }}" class="action-item">
                    <span class="action-icon" style="background: var(--yellow);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <line x1="2" y1="10" x2="22" y2="10"></line>
                        </svg>
                    </span>
                    <span class="action-label">Gérer les cotisations</span>
                    <span class="action-arrow">→</span>
                </a>

                <a href="{{ route('members.index') }}" class="action-item">
                    <span class="action-icon" style="background: var(--blue);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                        </svg>
                    </span>
                    <span class="action-label">Liste des membres</span>
                    <span class="action-arrow">→</span>
                </a>

                <a href="#" class="action-item">
                    <span class="action-icon" style="background: var(--red);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                        </svg>
                    </span>
                    <span class="action-label">Statistiques avancées</span>
                    <span class="action-arrow">→</span>
                </a>
            </div>
        </div>

        <!-- Section Aperçu des dernières activités -->
        <div class="dashboard-card activities-card">
            <div class="card-header">
                <h2>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    Activités récentes
                </h2>
                <span class="badge">Live</span>
            </div>
            
            <div class="activities-list">
                <div class="activity-item">
                    <div class="activity-dot" style="background: var(--green);"></div>
                    <div class="activity-content">
                        <p class="activity-text">Nouveau membre ajouté</p>
                        <p class="activity-time">Il y a 5 minutes</p>
                    </div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-dot" style="background: var(--blue);"></div>
                    <div class="activity-content">
                        <p class="activity-text">Cotisation enregistrée</p>
                        <p class="activity-time">Il y a 2 heures</p>
                    </div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-dot" style="background: var(--yellow);"></div>
                    <div class="activity-content">
                        <p class="activity-text">Mise à jour du profil</p>
                        <p class="activity-time">Il y a 1 jour</p>
                    </div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-dot" style="background: var(--red);"></div>
                    <div class="activity-content">
                        <p class="activity-text">Nouvelle cotisation</p>
                        <p class="activity-time">Il y a 2 jours</p>
                    </div>
                </div>
            </div>
            
            <a href="#" class="view-all">
                Voir toutes les activités
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </a>
        </div>
    </div>

    <!-- Graphique simplifié des cotisations -->
    <div class="dashboard-card chart-card">
        <div class="card-header">
            <h2>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 12v-2a5 5 0 0 0-5-5H8a5 5 0 0 0-5 5v2"></path>
                    <circle cx="12" cy="16" r="5"></circle>
                    <line x1="12" y1="11" x2="12" y2="16"></line>
                </svg>
                Évolution des cotisations
            </h2>
            <select class="chart-select">
                <option>Cette année</option>
                <option>Ce mois</option>
                <option>Cette semaine</option>
            </select>
        </div>
        
        <div class="chart-container">
            @php
                $mois = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'];
                $valeurs = [65, 59, 80, 81, 56, 55];
                $max = max($valeurs);
            @endphp
            
            <div class="chart-bars">
                @foreach($valeurs as $index => $valeur)
                    <div class="chart-bar-item">
                        <div class="bar-container">
                            <div class="bar" style="height: {{ ($valeur / $max) * 150 }}px; background: var(--blue);"></div>
                        </div>
                        <span class="bar-label">{{ $mois[$index] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
/* ===== VARIABLES ===== */
:root {
    --blue: #1f4fd8;
    --green: #1fa85b;
    --yellow: #f2c200;
    --red: #d62828;
    --black: #111111;
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
}

/* ===== CONTAINER PRINCIPAL ===== */
.admin-dashboard {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1.5rem;
    position: relative;
    min-height: 100vh;
}

/* ===== ÉLÉMENTS DÉCORATIFS ===== */
.dashboard-bg {
    position: fixed;
    width: 400px;
    height: 400px;
    border-radius: 50%;
    filter: blur(100px);
    z-index: 0;
    opacity: 0.1;
    pointer-events: none;
}

.decoration-1 {
    background: var(--blue);
    top: -100px;
    right: -100px;
    animation: float 20s infinite;
}

.decoration-2 {
    background: var(--green);
    bottom: -100px;
    left: -100px;
    animation: float 25s infinite reverse;
}

@keyframes float {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    33% { transform: translate(30px, -30px) rotate(5deg); }
    66% { transform: translate(-30px, 20px) rotate(-5deg); }
}

/* ===== EN-TÊTE ===== */
.dashboard-header-card {
    background: white;
    border-radius: 1.5rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--gray-200);
    position: relative;
    z-index: 10;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.welcome-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: rgba(31, 79, 216, 0.1);
    color: var(--blue);
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 1rem;
}

.welcome-badge svg {
    width: 1rem;
    height: 1rem;
}

.dashboard-title {
    font-size: 2rem;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0 0 0.5rem 0;
}

.user-name {
    color: var(--green);
    position: relative;
    display: inline-block;
}

.user-name::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, var(--green), transparent);
    border-radius: 3px;
}

.dashboard-date {
    color: var(--gray-500);
    font-size: 1rem;
    margin: 0;
    text-transform: capitalize;
}

.admin-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, var(--yellow), #fbbf24);
    color: var(--gray-800);
    border-radius: 3rem;
    font-weight: 600;
    box-shadow: 0 4px 6px rgba(242, 194, 0, 0.3);
}

.admin-badge svg {
    width: 1.25rem;
    height: 1.25rem;
}

/* ===== STATISTIQUES ===== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
    position: relative;
    z-index: 10;
}

.stat-card {
    background: white;
    border-radius: 1.25rem;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.25rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--blue), var(--green), var(--yellow), var(--red));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-xl);
}

.stat-card:hover::before {
    opacity: 1;
}

.stat-icon {
    width: 3.5rem;
    height: 3.5rem;
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-icon svg {
    width: 2rem;
    height: 2rem;
}

.stat-content {
    flex: 1;
}

.stat-content h3 {
    font-size: 0.875rem;
    color: var(--gray-500);
    margin: 0 0 0.25rem 0;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.stat-number {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--gray-800);
    margin: 0 0 0.25rem 0;
    line-height: 1.2;
}

.stat-trend {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--gray-500);
}

.stat-trend.positive {
    color: var(--green);
}

.stat-trend svg {
    width: 0.875rem;
    height: 0.875rem;
}

/* ===== GRILLE DASHBOARD ===== */
.dashboard-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
    position: relative;
    z-index: 10;
}

.dashboard-card {
    background: white;
    border-radius: 1.5rem;
    padding: 1.5rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
}

.dashboard-card:hover {
    box-shadow: var(--shadow-xl);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.card-header h2 {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0;
}

.card-header h2 svg {
    width: 1.25rem;
    height: 1.25rem;
    color: var(--blue);
}

.card-header .badge {
    padding: 0.25rem 0.75rem;
    background: var(--gray-100);
    color: var(--gray-600);
    border-radius: 2rem;
    font-size: 0.75rem;
    font-weight: 500;
}

/* ===== ACTIONS RAPIDES ===== */
.actions-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.action-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: var(--gray-50);
    border-radius: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.action-item:hover {
    background: white;
    border-color: var(--gray-200);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.action-icon {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.action-icon svg {
    width: 1.25rem;
    height: 1.25rem;
}

.action-label {
    flex: 1;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--gray-700);
}

.action-arrow {
    color: var(--gray-400);
    font-size: 1.125rem;
    transition: transform 0.3s ease;
}

.action-item:hover .action-arrow {
    transform: translateX(4px);
    color: var(--blue);
}

/* ===== ACTIVITÉS RÉCENTES ===== */
.activities-list {
    margin-bottom: 1rem;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--gray-200);
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-dot {
    width: 0.5rem;
    height: 0.5rem;
    border-radius: 50%;
    margin-top: 0.5rem;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.5); opacity: 0.5; }
}

.activity-content {
    flex: 1;
}

.activity-text {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--gray-700);
    margin: 0 0 0.25rem 0;
}

.activity-time {
    font-size: 0.75rem;
    color: var(--gray-500);
    margin: 0;
}

.view-all {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem;
    background: var(--gray-50);
    border-radius: 0.75rem;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--blue);
    transition: all 0.3s ease;
}

.view-all:hover {
    background: var(--blue);
    color: white;
}

.view-all svg {
    width: 1rem;
    height: 1rem;
}

/* ===== GRAPHIQUE ===== */
.chart-card {
    position: relative;
    z-index: 10;
}

.chart-select {
    padding: 0.5rem 2rem 0.5rem 1rem;
    border: 2px solid var(--gray-200);
    border-radius: 0.75rem;
    font-size: 0.875rem;
    color: var(--gray-700);
    background: white;
    cursor: pointer;
    outline: none;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.5rem center;
    background-size: 1rem;
}

.chart-container {
    padding: 1rem 0;
}

.chart-bars {
    display: flex;
    justify-content: space-around;
    align-items: flex-end;
    height: 200px;
}

.chart-bar-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    width: 40px;
}

.bar-container {
    width: 100%;
    height: 150px;
    display: flex;
    align-items: flex-end;
}

.bar {
    width: 100%;
    background: var(--blue);
    border-radius: 0.5rem 0.5rem 0 0;
    transition: height 1s ease;
    animation: growBar 1s ease-out;
}

@keyframes growBar {
    from { height: 0; }
    to { height: var(--height); }
}

.bar-label {
    font-size: 0.75rem;
    color: var(--gray-500);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 1024px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .admin-dashboard {
        padding: 1rem;
    }

    .dashboard-header-card {
        padding: 1.5rem;
    }

    .dashboard-title {
        font-size: 1.5rem;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .actions-grid {
        grid-template-columns: 1fr;
    }

    .chart-bars {
        gap: 0.5rem;
    }

    .chart-bar-item {
        width: 30px;
    }

    .header-content {
        flex-direction: column;
        align-items: flex-start;
    }

    .admin-badge {
        align-self: flex-start;
    }
}

@media (max-width: 480px) {
    .chart-bars {
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }
    
    .chart-bar-item {
        min-width: 40px;
    }
}

/* ===== ANIMATIONS SUPPRÉMENTAIRES ===== */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card,
.dashboard-card {
    animation: slideIn 0.5s ease-out forwards;
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }
.dashboard-card:nth-child(1) { animation-delay: 0.3s; }
.dashboard-card:nth-child(2) { animation-delay: 0.4s; }
</style>

<script>
// Animation des barres du graphique
document.addEventListener('DOMContentLoaded', function() {
    const bars = document.querySelectorAll('.bar');
    bars.forEach(bar => {
        const height = bar.style.height;
        bar.style.setProperty('--height', height);
    });
});
</script>
@endsection