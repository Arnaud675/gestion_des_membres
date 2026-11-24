@extends('layouts.app')

@section('title', 'Détails de la dépense')

@section('content')
<div class="depense-show-container">
    <div class="page-header">
        <div class="header-left">
            <a href="{{ route('depenses.index') }}" class="btn-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Retour
            </a>
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                </svg>
                Détails de la dépense
            </h1>
            <p class="page-subtitle">Informations complètes sur ce règlement</p>
        </div>
        <div class="header-actions">
            <span class="ref-badge-large">{{ $depense->reference }}</span>
        </div>
    </div>

    <div class="details-card">
        <!-- En-tête avec montant et type -->
        <div class="details-header">
            <div class="badge badge-yellow" style="font-size: 14px; padding: 6px 14px;">
                {{ $depense->type_evenement_label }}
            </div>
            <div class="montant-large">
                <span class="montant-label">Montant décaissé</span>
                <span class="montant-value">{{ number_format($depense->montant, 0, ',', ' ') }} FCFA</span>
            </div>
        </div>

        <!-- Grille d'informations -->
        <div class="info-grid-details">
            <div class="info-card-details">
                <div class="info-icon" style="background: var(--blue-soft); color: var(--blue);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div class="info-content">
                    <span class="info-label">Membre bénéficiaire</span>
                    <span class="info-value">{{ $depense->member->nom }} {{ $depense->member->prenoms }}</span>
                </div>
            </div>

            <div class="info-card-details">
                <div class="info-icon" style="background: var(--green-soft); color: var(--green);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                    </svg>
                </div>
                <div class="info-content">
                    <span class="info-label">Date du paiement</span>
                    <span class="info-value">{{ $depense->date_depense->format('d/m/Y') }}</span>
                </div>
            </div>

            <div class="info-card-details">
                <div class="info-icon" style="background: var(--yellow-soft); color: var(--yellow-dark);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <div class="info-content">
                    <span class="info-label">Enregistré par</span>
                    <span class="info-value">{{ $depense->createur->name }}</span>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="info-section" style="margin-top: 16px;">
            <h3 class="section-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
                Description / Motif
            </h3>
            <p style="color: var(--text-body); font-size: 14px; line-height: 1.6;">
                {{ $depense->description ?: 'Aucune description fournie.' }}
            </p>
        </div>

        <!-- Actions -->
        <div class="profile-actions" style="margin-top: 24px;">
            <a href="{{ route('members.show', $depense->member_id) }}" class="btn btn-outline">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Fiche du membre
            </a>

            @if(auth()->user()->canManageDepenses())
                <div class="action-group">
                    <a href="{{ route('depenses.edit', $depense) }}" class="btn btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                            <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                        </svg>
                        Modifier
                    </a>

                    <form action="{{ route('depenses.destroy', $depense) }}" method="POST" style="margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer définitivement cette dépense ?')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                            Supprimer
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
