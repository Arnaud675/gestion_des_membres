@extends('layouts.app')

@section('title', 'Ajouter un membre')

@section('content')
<div class="members-container">
    <!-- En-tête de page -->
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
                Ajouter un nouveau membre
            </h1>
            <p class="page-subtitle">Renseignez les informations du fidèle dans le formulaire ci-dessous</p>
        </div>
    </div>

    <!-- Carte du formulaire -->
    <div class="form-card">
        <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data" class="modern-form">
            @csrf

            <!-- Progression visuelle -->
            <div class="form-progress">
                <div class="progress-step active">
                    <span class="step-number">1</span>
                    <span class="step-label">Identité</span>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step">
                    <span class="step-number">2</span>
                    <span class="step-label">Filiation</span>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step">
                    <span class="step-number">3</span>
                    <span class="step-label">Profession</span>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step">
                    <span class="step-number">4</span>
                    <span class="step-label">Contact</span>
                </div>
            </div>

            <!-- Section 1: Identité -->
            <div class="form-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Informations d'identité</h2>
                        <p>État civil et informations personnelles</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Numéro de membre <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="text" name="numero_membre" value="{{ old('numero_membre') }}" required 
                                       placeholder="Ex: MBR-2024-001" class="form-input">
                            </div>
                            @error('numero_membre')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Nom <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="text" name="nom" value="{{ old('nom') }}" required 
                                       placeholder="Ex: ASSOUKA" class="form-input">
                            </div>
                            @error('nom')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Prénoms <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="text" name="prenoms" value="{{ old('prenoms') }}" required 
                                       placeholder="Ex: LE BRAVE" class="form-input">
                            </div>
                            @error('prenoms')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Date de naissance <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="date" name="date_naissance" value="{{ old('date_naissance') }}" required 
                                       class="form-input">
                            </div>
                            @error('date_naissance')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Lieu de naissance <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance') }}" required 
                                       placeholder="Ex: Lomé" class="form-input">
                            </div>
                            @error('lieu_naissance')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Nationalité</label>
                        <div class="select-wrapper">
                            <select name="nationalite" class="form-select">
                                <option value="" {{ old('nationalite') ? '' : 'selected' }}>Sélectionnez une option</option>
                                @include('members.partials.member-select-options', [
                                    'options' => config('member_options.nationalities'),
                                    'selected' => old('nationalite'),
                                ])
                            </select>
                        </div>
                        @error('nationalite')
                            <span class="error-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Filiation -->
            <div class="form-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Filiation</h2>
                        <p>Informations sur les parents</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nom du père</label>
                            <div class="input-group">
                                <input type="text" name="nom_pere" value="{{ old('nom_pere') }}" 
                                       placeholder="Ex: GATO Pierre" class="form-input">
                            </div>
                            @error('nom_pere')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Nom de la mère</label>
                            <div class="input-group">
                                <input type="text" name="nom_mere" value="{{ old('nom_mere') }}" 
                                       placeholder="Ex: GATO Marie" class="form-input">
                            </div>
                            @error('nom_mere')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Profession et situation -->
            <div class="form-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Profession & Situation</h2>
                        <p>Activité professionnelle et situation familiale</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Profession</label>
                            <div class="select-wrapper">
                                <select name="profession" class="form-select">
                                    <option value="" {{ old('profession') ? '' : 'selected' }}>Sélectionnez une option</option>
                                    @include('members.partials.member-select-options', [
                                        'options' => config('member_options.professions'),
                                        'selected' => old('profession'),
                                    ])
                                </select>
                            </div>
                            @error('profession')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Situation Matrimoniale</label>
                            <div class="select-wrapper">
                                <select name="situation_matrimoniale" class="form-select">
                                    <option value="" disabled selected>Sélectionnez une option</option>
                                    <option value="célibataire" {{ old('situation_matrimoniale') == 'célibataire' ? 'selected' : '' }}>Célibataire</option>
                                    <option value="marié(e)" {{ old('situation_matrimoniale') == 'marié(e)' ? 'selected' : '' }}>Marié(e)</option>
                                    <option value="divorcé(e)" {{ old('situation_matrimoniale') == 'divorcé(e)' ? 'selected' : '' }}>Divorcé(e)</option>
                                    <option value="veuf(ve)" {{ old('situation_matrimoniale') == 'veuf(ve)' ? 'selected' : '' }}>Veuf(ve)</option>
                                </select>
                            </div>
                            @error('situation_matrimoniale')
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 4: Contact et photo -->
            <div class="form-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                    <div class="header-title">
                        <h2>Contact & Photo</h2>
                        <p>Coordonnées et photo d'identité</p>
                    </div>
                </div>

                <div class="section-body">
                    <div class="form-group">
                        <label>Adresse complète</label>
                        <div class="input-group">
                            <textarea name="adresse" rows="3" class="form-textarea" 
                                      placeholder="Ex: 123 Rue de la République, 701 Lomé, 90 10 72 00">{{ old('adresse') }}</textarea>
                        </div>
                        @error('adresse')
                            <span class="error-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group photo-upload">
                        <label>Photo d'identité</label>
                        <div class="photo-container">
                            <div class="photo-preview" id="photoPreview">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <rect x="2" y="2" width="20" height="20" rx="2.18"></rect>
                                    <path d="M7 2v20M17 2v20M2 12h20M2 7h5M2 17h5M17 17h5M17 7h5"></path>
                                </svg>
                                <span>Aperçu</span>
                            </div>
                            <div class="photo-actions">
                                <input type="file" name="photo" accept="image/*" id="photoInput" class="file-input">
                                <label for="photoInput" class="file-label">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M23 19v2a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-2"></path>
                                        <polyline points="16 2 12 6 8 2"></polyline>
                                        <line x1="12" y1="6" x2="12" y2="16"></line>
                                    </svg>
                                    Choisir un fichier
                                </label>
                                <p class="file-hint">PNG, JPG ou JPEG (Max. 2 Mo)</p>
                            </div>
                        </div>
                        @error('photo')
                            <span class="error-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Actions du formulaire -->
            <div class="form-actions">
                <a href="{{ route('members.index') }}" class="btn btn-outline">
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
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Enregistrer le membre
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Prévisualisation de la photo
document.getElementById('photoInput')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            showToast('Le fichier est trop volumineux. Taille maximum : 2 Mo', 'error');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('photoPreview');
            preview.style.backgroundImage = `url('${e.target.result}')`;
            preview.style.backgroundSize = 'cover';
            preview.style.backgroundPosition = 'center';
            preview.innerHTML = '';
        }
        reader.readAsDataURL(file);
    }
});

// Animation des étapes de progression
document.querySelectorAll('.form-input, .form-select, .form-textarea').forEach(input => {
    input.addEventListener('focus', () => {
        const section = input.closest('.form-section');
        const sections = Array.from(document.querySelectorAll('.form-section'));
        const index = sections.indexOf(section);
        if (index >= 0) {
            const steps = document.querySelectorAll('.progress-step');
            steps.forEach((s, i) => {
                s.classList.toggle('active', i <= index);
            });
        }
    });
});
</script>
@endpush
@endsection
