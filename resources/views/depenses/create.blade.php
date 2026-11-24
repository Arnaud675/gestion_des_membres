@extends('layouts.app')

@section('title', 'Nouvelle dépense')

@section('content')
<div class="depense-create-container">
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
                Nouvelle dépense
            </h1>
            <p class="page-subtitle">Enregistrement d'une dépense de caisse pour un membre</p>
        </div>
    </div>

    <div class="form-card">
        <form action="{{ route('depenses.store') }}" method="POST" class="modern-form">
            @csrf

            <!-- Solde global info -->
            <div class="solde-info-card">
                <div class="solde-info-content">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 8v8M8 12h8"></path>
                    </svg>
                    <div>
                        <span class="solde-label">Solde global disponible</span>
                        <span class="solde-value">{{ number_format($soldeGlobal, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>

            <!-- Section 1: Membre -->
            <div class="form-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Membre bénéficiaire</h2>
                        <p>Sélectionnez le fidèle concerné par cette dépense</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-group">
                        <label>Membre <span class="required">*</span></label>
                        <div class="select-wrapper">
                            <select name="member_id" id="memberSelect" class="form-select" required>
                                <option value="" disabled {{ old('member_id') ? '' : 'selected' }}>-- Sélectionner un membre --</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->nom }} {{ $member->prenoms }} (N° {{ $member->numero_membre }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('member_id')
                            <span class="error-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Type et montant -->
            <div class="form-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Nature de la dépense</h2>
                        <p>Type d'événement, montant et date</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Type d'événement <span class="required">*</span></label>
                            <div class="select-wrapper">
                                <select name="type_evenement" id="typeSelect" class="form-select" required>
                                    <option value="" disabled {{ old('type_evenement') ? '' : 'selected' }}>-- Type d'événement --</option>
                                    @foreach($typesEvenements as $value => $label)
                                        <option value="{{ $value }}" {{ old('type_evenement') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('type_evenement')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Montant <span class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-prefix">FCFA</span>
                                <input type="number" name="montant" id="montantInput" class="form-input with-prefix" 
                                       value="{{ old('montant') }}" min="1" step="1" 
                                       placeholder="Ex: 50 000" required>
                            </div>
                            <small class="input-hint" id="montantHint">Solde disponible : {{ number_format($soldeGlobal, 0, ',', ' ') }} FCFA</small>
                            @error('montant')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Date de dépense <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="date" name="date_depense" class="form-input" 
                                       value="{{ old('date_depense', date('Y-m-d')) }}" required>
                            </div>
                            @error('date_depense')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description / Motif</label>
                        <textarea name="description" class="form-textarea" rows="3" 
                                  placeholder="Décrivez brièvement le contexte de la dépense...">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="error-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 3: Récapitulatif -->
            <div class="form-section summary-section">
                <div class="summary-header">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    <span>Récapitulatif</span>
                </div>
                <div class="summary-content">
                    <div class="summary-item">
                        <span class="summary-label">Membre</span>
                        <span class="summary-value" id="summaryMember">Non sélectionné</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Type</span>
                        <span class="summary-value" id="summaryType">-</span>
                    </div>
                    <div class="summary-item highlight">
                        <span class="summary-label">Montant</span>
                        <span class="summary-value" id="summaryAmount">0 FCFA</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Date</span>
                        <span class="summary-value" id="summaryDate">-</span>
                    </div>
                </div>
                <div class="summary-note">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                    </svg>
                    Cette dépense sera déduite directement du solde global de la caisse
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="form-actions">
                <a href="{{ route('depenses.index') }}" class="btn btn-outline">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    </svg>
                    Enregistrer la dépense
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
const soldeGlobal = {{ $soldeGlobal }};

document.addEventListener('DOMContentLoaded', function() {
    const memberSelect = document.getElementById('memberSelect');
    const typeSelect = document.getElementById('typeSelect');
    const montantInput = document.getElementById('montantInput');
    const dateInput = document.querySelector('input[name="date_depense"]');
    
    const summaryMember = document.getElementById('summaryMember');
    const summaryType = document.getElementById('summaryType');
    const summaryAmount = document.getElementById('summaryAmount');
    const summaryDate = document.getElementById('summaryDate');
    const montantHint = document.getElementById('montantHint');
    
    const typesEvenements = {
        @foreach($typesEvenements as $value => $label) '{{ $value }}': '{{ $label }}', @endforeach
    };
    
    function formatNumber(value) {
        return new Intl.NumberFormat('fr-FR').format(value);
    }
    
    function updateSummary() {
        if (memberSelect && memberSelect.value) {
            summaryMember.textContent = memberSelect.options[memberSelect.selectedIndex]?.text.split('(')[0] || 'Non sélectionné';
        }
        if (typeSelect && typeSelect.value) {
            summaryType.textContent = typesEvenements[typeSelect.value] || '-';
        }
        if (montantInput && montantInput.value) {
            const montant = parseFloat(montantInput.value);
            summaryAmount.textContent = formatNumber(montant) + ' FCFA';
            if (!isNaN(montant) && montant > soldeGlobal) {
                montantHint.style.color = 'var(--red)';
                montantHint.innerHTML = '⚠️ Montant supérieur au solde disponible (' + formatNumber(soldeGlobal) + ' FCFA)';
            } else {
                montantHint.style.color = 'var(--text-muted)';
                montantHint.innerHTML = 'Solde disponible : ' + formatNumber(soldeGlobal) + ' FCFA';
            }
        }
        if (dateInput && dateInput.value) {
            const date = new Date(dateInput.value);
            summaryDate.textContent = date.toLocaleDateString('fr-FR');
        }
    }
    
    if (memberSelect) memberSelect.addEventListener('change', updateSummary);
    if (typeSelect) typeSelect.addEventListener('change', updateSummary);
    if (montantInput) montantInput.addEventListener('input', updateSummary);
    if (dateInput) dateInput.addEventListener('change', updateSummary);
    
    updateSummary();
});
</script>
@endpush
@endsection
