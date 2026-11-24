@extends('layouts.app')

@section('title', 'Nouvelle cotisation')

@section('content')
<div class="cotisation-container">
    <!-- En-tête de page -->
    <div class="page-header">
        <div class="header-left">
            <a href="{{ route('cotisations.index') }}" class="btn-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Retour
            </a>
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                    <line x1="2" y1="10" x2="22" y2="10"></line>
                </svg>
                Nouvelle cotisation
            </h1>
            <p class="page-subtitle">Enregistrement d'un versement de cotisation pour un membre</p>
        </div>
    </div>

    <!-- Formulaire de cotisation -->
    <div class="form-card">
        <form action="{{ route('cotisations.store') }}" method="POST" class="modern-form">
            @csrf

            <!-- Sélection du membre -->
            <div class="form-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Membre concerné</h2>
                        <p>Sélectionnez le membre pour lequel vous ajoutez une cotisation</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-group">
                        <label>Membre <span class="required">*</span></label>
                        <div class="select-wrapper">
                            <select name="member_id" class="form-select" required>
                                <option value="" disabled {{ old('member_id') ? '' : 'selected' }}>-- Choisir un membre --</option>
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

            <!-- Période de cotisation -->
            <div class="form-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Période de cotisation</h2>
                        <p>Mois et année concernés par le paiement</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Mois <span class="required">*</span></label>
                            <div class="select-wrapper">
                                <select name="mois" class="form-select" required>
                                    <option value="" disabled {{ old('mois') ? '' : 'selected' }}>-- Sélectionner un mois --</option>
                                    @php
                                        $moisNoms = [
                                            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                                            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                                            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                                        ];
                                    @endphp
                                    @foreach($moisNoms as $numero => $nom)
                                        <option value="{{ $numero }}" {{ old('mois', date('n')) == $numero ? 'selected' : '' }}>
                                            {{ $nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('mois')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Année <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="number" name="annee" class="form-input" 
                                       value="{{ old('annee', date('Y')) }}" 
                                       min="2020" max="{{ date('Y') + 1 }}" required>
                            </div>
                            @error('annee')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Montant et date -->
            <div class="form-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Détails du paiement</h2>
                        <p>Montant versé et date du règlement</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Montant <span class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-prefix">CFA</span>
                                <input type="number" name="montant" class="form-input with-prefix" 
                                       value="{{ old('montant') }}" 
                                       min="1" max="1000" step="0.01" 
                                       placeholder="1000" required>
                            </div>
                            <small class="input-hint">Maximum 1 000 FCFA par mois</small>
                            @error('montant')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Date de paiement <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="date" name="date_paiement" class="form-input" 
                                       value="{{ old('date_paiement', date('Y-m-d')) }}" required>
                            </div>
                            @error('date_paiement')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Récapitulatif dynamique -->
            <div class="form-section summary-section">
                <div class="summary-header">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    <span>Récapitulatif</span>
                </div>
                <div class="summary-content" style="grid-template-columns: repeat(3, 1fr);">
                    <div class="summary-item">
                        <span class="summary-label">Membre</span>
                        <span class="summary-value" id="summaryMember">Non sélectionné</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Période</span>
                        <span class="summary-value" id="summaryPeriod">-</span>
                    </div>
                    <div class="summary-item highlight">
                        <span class="summary-label">Montant</span>
                        <span class="summary-value" id="summaryAmount">0 CFA</span>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="form-actions">
                <a href="{{ route('cotisations.index') }}" class="btn btn-outline">
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
                    Enregistrer la cotisation
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const memberSelect = document.querySelector('select[name="member_id"]');
    const moisSelect = document.querySelector('select[name="mois"]');
    const anneeInput = document.querySelector('input[name="annee"]');
    const montantInput = document.querySelector('input[name="montant"]');
    
    const summaryMember = document.getElementById('summaryMember');
    const summaryPeriod = document.getElementById('summaryPeriod');
    const summaryAmount = document.getElementById('summaryAmount');
    
    const moisNoms = {
        1: 'Janvier', 2: 'Février', 3: 'Mars', 4: 'Avril',
        5: 'Mai', 6: 'Juin', 7: 'Juillet', 8: 'Août',
        9: 'Septembre', 10: 'Octobre', 11: 'Novembre', 12: 'Décembre'
    };
    
    function updateSummary() {
        if (memberSelect && memberSelect.value) {
            summaryMember.textContent = memberSelect.options[memberSelect.selectedIndex]?.text || 'Non sélectionné';
        } else {
            summaryMember.textContent = 'Non sélectionné';
        }
        
        if (moisSelect && moisSelect.value && anneeInput && anneeInput.value) {
            const moisNom = moisNoms[moisSelect.value] || '?';
            summaryPeriod.textContent = `${moisNom} ${anneeInput.value}`;
        } else {
            summaryPeriod.textContent = '-';
        }
        
        if (montantInput && montantInput.value) {
            const montant = parseFloat(montantInput.value).toFixed(2);
            summaryAmount.textContent = `${montant} CFA`;
        } else {
            summaryAmount.textContent = '0 CFA';
        }
    }
    
    if (memberSelect) memberSelect.addEventListener('change', updateSummary);
    if (moisSelect) moisSelect.addEventListener('change', updateSummary);
    if (anneeInput) anneeInput.addEventListener('input', updateSummary);
    if (montantInput) montantInput.addEventListener('input', updateSummary);
    
    updateSummary();
});
</script>
@endpush
@endsection
