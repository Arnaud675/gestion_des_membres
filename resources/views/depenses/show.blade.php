{{-- resources/views/depenses/show.blade.php --}}
@extends('layouts.app')

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
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
                Détails de la dépense
            </h1>
        </div>
        <div class="ref-badge-large">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 4v16h16V4H4z"></path>
                <line x1="8" y1="9" x2="16" y2="9"></line>
                <line x1="8" y1="13" x2="12" y2="13"></line>
            </svg>
            <span>{{ $depense->reference }}</span>
        </div>
    </div>

    <div class="details-card">
        <!-- En-tête avec montant et type -->
        <div class="details-header">
            <div class="header-badge type-{{ $depense->type_evenement }}">
                {{ $depense->type_evenement_label }}
            </div>
            <div class="montant-large">
                <span class="montant-label">Montant</span>
                <span class="montant-value">{{ number_format($depense->montant, 0, ',', ' ') }} FCFA</span>
            </div>
        </div>

        <!-- Grille d'informations -->
        <div class="info-grid-details">
            <div class="info-card-details">
                <div class="info-icon" style="background: rgba(31, 79, 216, 0.1); color: var(--blue);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div class="info-content">
                    <span class="info-label">Membre concerné</span>
                    <span class="info-value">{{ $depense->member->nom }} {{ $depense->member->prenoms }}</span>
                </div>
            </div>

            <div class="info-card-details">
                <div class="info-icon" style="background: rgba(31, 168, 91, 0.1); color: var(--green);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <div class="info-content">
                    <span class="info-label">Date de dépense</span>
                    <span class="info-value">{{ $depense->date_depense->format('d/m/Y') }}</span>
                </div>
            </div>

            <div class="info-card-details">
                <div class="info-icon" style="background: rgba(242, 194, 0, 0.1); color: var(--yellow);">
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

            <div class="info-card-details">
                <div class="info-icon" style="background: rgba(214, 40, 40, 0.1); color: var(--red);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                </div>
                <div class="info-content">
                    <span class="info-label">Date d'enregistrement</span>
                    <span class="info-value">{{ $depense->created_at->format('d/m/Y à H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Description -->
        @if($depense->description)
        <div class="description-section">
            <h3>Description</h3>
            <p>{{ $depense->description }}</p>
        </div>
        @endif

        <!-- Impact sur la caisse -->
        <div class="impact-section">
            <h3>Impact sur la caisse</h3>
            <div class="impact-grid">
                <div class="impact-item">
                    <span class="impact-label">Solde global actuel</span>
                    <span class="impact-value">{{ number_format($soldeGlobal, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="impact-item">
                    <span class="impact-label">Cette dépense a déduit</span>
                    <span class="impact-value negative">- {{ number_format($depense->montant, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="impact-item highlight">
                    <span class="impact-label">Nouveau solde après dépense</span>
                    <span class="impact-value">{{ number_format($soldeGlobal + $depense->montant, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="details-actions">
            @if(!auth()->user()->isAdmin())
                <a href="{{ route('depenses.edit', $depense) }}" class="btn-edit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                        <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                    </svg>
                    Modifier
                </a>
                <form action="{{ route('depenses.destroy', $depense) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete" onclick="return confirm('Supprimer cette dépense ? Cette action est irréversible.')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        </svg>
                        Supprimer
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

<style>
.depense-show-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 0 1.5rem;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
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
    background: white;
    color: var(--gray-600);
    border: 2px solid var(--gray-200);
    border-radius: 0.75rem;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-back:hover {
    background: var(--gray-50);
    border-color: var(--gray-300);
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

.ref-badge-large {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--gray-100);
    border-radius: 0.75rem;
    font-family: monospace;
    font-size: 1rem;
    font-weight: 600;
    color: var(--blue);
    border: 1px solid var(--gray-200);
}

.ref-badge-large svg {
    width: 1.25rem;
    height: 1.25rem;
    color: var(--gray-400);
}

.details-card {
    background: white;
    border-radius: 1.5rem;
    box-shadow: var(--shadow-xl);
    overflow: hidden;
    border: 1px solid var(--gray-200);
}

.details-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
    border-bottom: 1px solid var(--gray-200);
    flex-wrap: wrap;
    gap: 1rem;
}

.header-badge {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-size: 0.9rem;
    font-weight: 600;
}

.type-enterrement { background: #e5e7eb; color: #374151; }
.type-aide_sociale { background: #fee2e2; color: #dc2626; }
.type-evenement_religieux { background: #e8edff; color: #1f4fd8; }
.type-urgence_medicale { background: #fed7aa; color: #ea580c; }
.type-projet_communautaire { background: #e8f5e9; color: #16a34a; }
.type-mariage { background: #fce7f3; color: #db2777; }
.type-naissance { background: #d1fae5; color: #059669; }
.type-autre { background: #f3e8ff; color: #9333ea; }

.montant-large {
    text-align: right;
}

.montant-label {
    display: block;
    font-size: 0.75rem;
    color: var(--gray-500);
    text-transform: uppercase;
}

.montant-value {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--green-dark);
}

.info-grid-details {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--gray-200);
}

.info-card-details {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--gray-50);
    border-radius: 1rem;
    transition: all 0.2s;
}

.info-card-details:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.info-icon {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.info-icon svg {
    width: 1.25rem;
    height: 1.25rem;
}

.info-content {
    flex: 1;
}

.info-label {
    display: block;
    font-size: 0.7rem;
    color: var(--gray-500);
    text-transform: uppercase;
    margin-bottom: 0.25rem;
}

.info-value {
    display: block;
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--gray-800);
}

.description-section {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--gray-200);
}

.description-section h3 {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-500);
    text-transform: uppercase;
    margin-bottom: 0.5rem;
}

.description-section p {
    font-size: 0.95rem;
    color: var(--gray-700);
    line-height: 1.5;
    margin: 0;
}

.impact-section {
    padding: 1.5rem 2rem;
    background: var(--yellow-soft);
    border-bottom: 1px solid var(--gray-200);
}

.impact-section h3 {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-600);
    text-transform: uppercase;
    margin-bottom: 1rem;
}

.impact-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.impact-item {
    text-align: center;
    padding: 0.75rem;
    background: white;
    border-radius: 0.75rem;
}

.impact-item.highlight {
    background: var(--green-soft);
    border: 1px solid var(--green);
}

.impact-label {
    display: block;
    font-size: 0.7rem;
    color: var(--gray-500);
    margin-bottom: 0.25rem;
}

.impact-value {
    display: block;
    font-size: 1rem;
    font-weight: 700;
    color: var(--gray-800);
}

.impact-value.negative {
    color: var(--red);
}

.impact-item.highlight .impact-value {
    color: var(--green-dark);
    font-size: 1.1rem;
}

.details-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    padding: 1.5rem 2rem;
}

.btn-edit {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--yellow-soft);
    color: var(--yellow-dark);
    border-radius: 0.75rem;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s;
    border: 1px solid var(--yellow);
}

.btn-edit:hover {
    background: var(--yellow);
    color: white;
    transform: translateY(-2px);
}

.btn-edit svg {
    width: 1.25rem;
    height: 1.25rem;
}

.btn-delete {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--red-soft);
    color: var(--red-dark);
    border-radius: 0.75rem;
    border: none;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-delete:hover {
    background: var(--red);
    color: white;
    transform: translateY(-2px);
}

.btn-delete svg {
    width: 1.25rem;
    height: 1.25rem;
}

.delete-form {
    display: inline;
}

@media (max-width: 768px) {
    .depense-show-container { padding: 1rem; }
    .header-left { flex-direction: column; align-items: flex-start; }
    .page-title { font-size: 1.5rem; }
    .details-header { flex-direction: column; align-items: flex-start; }
    .montant-large { text-align: left; }
    .info-grid-details { grid-template-columns: 1fr; padding: 1rem; }
    .impact-grid { grid-template-columns: 1fr; }
    .details-actions { flex-direction: column; }
    .btn-edit, .btn-delete { width: 100%; justify-content: center; }
}
</style>
@endsection