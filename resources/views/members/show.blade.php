@extends('layouts.app')

@section('title', 'Profil membre')

@section('content')
<div class="member-details-container">
    <!-- En-tête avec navigation -->
    <div class="page-header">
        <div class="header-left">
            <a href="{{ route('members.index') }}" class="btn-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Retour à la liste
            </a>
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Fiche membre
            </h1>
            <p class="page-subtitle">Informations d'état civil et historique de l'adhérent</p>
        </div>
        <div class="header-actions">
            <span class="ref-badge-large">N° {{ $member->numero_membre }}</span>
        </div>
    </div>

    <!-- Carte principale -->
    <div class="profile-card">
        <div class="profile-content">
            <!-- Photo et informations principales -->
            <div class="profile-main">
                <div class="profile-avatar-wrapper">
                    @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" alt="Photo de {{ $member->nom }}" class="profile-avatar">
                    @else
                        <div class="profile-avatar-placeholder">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="profile-title">
                    <h2 class="profile-name">{{ $member->nom }} {{ $member->prenoms }}</h2>
                    <div class="profile-meta">
                        @if($member->profession)
                            <span class="badge badge-yellow">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                </svg>
                                {{ $member->profession }}
                            </span>
                        @endif
                        
                        @if($member->nationalite)
                            <span class="badge badge-blue">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                    <circle cx="12" cy="8" r="4"></circle>
                                    <path d="M5.8 15.2a8 8 0 0 1 12.4 0"></path>
                                </svg>
                                {{ $member->nationalite }}
                            </span>
                        @endif

                        @if($member->situation_matrimoniale)
                            <span class="badge badge-green">
                                {{ ucfirst($member->situation_matrimoniale) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Grille d'informations -->
            <div class="info-grid">
                <!-- Identité -->
                <div class="info-section">
                    <h3 class="section-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        État civil
                    </h3>
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">Date de naissance</span>
                            <span class="info-value">
                                {{ \Carbon\Carbon::parse($member->date_naissance)->format('d/m/Y') }}
                                <small style="color: var(--text-muted); font-weight: 500;">({{ \Carbon\Carbon::parse($member->date_naissance)->age }} ans)</small>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Lieu de naissance</span>
                            <span class="info-value">{{ $member->lieu_naissance ?: '—' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Situation matrimoniale</span>
                            <span class="info-value">{{ ucfirst($member->situation_matrimoniale ?: 'Non renseignée') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Filiation -->
                <div class="info-section">
                    <h3 class="section-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        Filiation
                    </h3>
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">Nom du père</span>
                            <span class="info-value">{{ $member->nom_pere ?: '—' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Nom de la mère</span>
                            <span class="info-value">{{ $member->nom_mere ?: '—' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Contact -->
                <div class="info-section">
                    <h3 class="section-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        Coordonnées
                    </h3>
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">Adresse</span>
                            <span class="info-value">{{ $member->adresse ?: '—' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date d'inscription</span>
                            <span class="info-value">{{ $member->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions du profil -->
            <div class="profile-actions">
                <a href="{{ route('members.cotisations', $member->id) }}" class="btn btn-outline">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                        <line x1="2" y1="10" x2="22" y2="10"></line>
                    </svg>
                    Historique des cotisations
                </a>

                @if(auth()->user()->canManageMembers())
                    <div class="action-group">
                        <a href="{{ route('members.edit', $member->id) }}" class="btn btn-primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                                <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                            </svg>
                            Modifier
                        </a>

                        <form action="{{ route('members.archive', $member->id) }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Archiver ce membre ? Son historique sera conservé.')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="21 8 21 21 3 21 3 8"></polyline>
                                    <rect x="1" y="3" width="22" height="5"></rect>
                                    <line x1="10" y1="12" x2="14" y2="12"></line>
                                </svg>
                                Archiver
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
