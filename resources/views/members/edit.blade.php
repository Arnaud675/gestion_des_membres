@extends('layouts.app')

@section('content')
<div class="form-wrapper">
    <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data" class="member-form">
        @csrf
        @method('PUT')

        <h2 class="form-title">Modifier le membre</h2>

        <div class="form-body">
            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="nom" value="{{ old('nom', $member->nom) }}" required>
                @error('nom') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Prénoms</label>
                <input type="text" name="prenoms" value="{{ old('prenoms', $member->prenoms) }}" required>
                @error('prenoms') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Date de naissance</label>
                    <input type="date" name="date_naissance" value="{{ old('date_naissance', $member->date_naissance) }}" required>
                    @error('date_naissance') <small class="error">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>Lieu de naissance</label>
                    <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance', $member->lieu_naissance) }}" required>
                    @error('lieu_naissance') <small class="error">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Nom du père</label>
                <input type="text" name="nom_pere" value="{{ old('nom_pere', $member->nom_pere) }}">
                @error('nom_pere') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Nom de la mère</label>
                <input type="text" name="nom_mere" value="{{ old('nom_mere', $member->nom_mere) }}">
                @error('nom_mere') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Profession</label>
                <input type="text" name="profession" value="{{ old('profession', $member->profession) }}">
                @error('profession') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Nationalité</label>
                <input type="text" name="nationalite" value="{{ old('nationalite', $member->nationalite) }}">
                @error('nationalite') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Situation Matrimoniale</label>
                <select name="situation_matrimoniale">
                    <option value="">-- Sélectionnez --</option>
                    <option value="célibataire" {{ old('situation_matrimoniale', $member->situation_matrimoniale) == 'célibataire' ? 'selected' : '' }}>Célibataire</option>
                    <option value="marié(e)" {{ old('situation_matrimoniale', $member->situation_matrimoniale) == 'marié(e)' ? 'selected' : '' }}>Marié(e)</option>
                    <option value="divorcé(e)" {{ old('situation_matrimoniale', $member->situation_matrimoniale) == 'divorcé(e)' ? 'selected' : '' }}>Divorcé(e)</option>
                    <option value="veuf(ve)" {{ old('situation_matrimoniale', $member->situation_matrimoniale) == 'veuf(ve)' ? 'selected' : '' }}>Veuf(ve)</option>
                </select>
                @error('situation_matrimoniale') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Adresse complète</label>
                <textarea name="adresse" rows="3">{{ old('adresse', $member->adresse) }}</textarea>
                @error('adresse') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Photo</label>
                @if($member->photo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $member->photo) }}" alt="photo" class="img-preview">
                    </div>
                @endif
                <input type="file" name="photo" accept="image/*">
                @error('photo') <small class="error">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="form-buttons">
            <a href="{{ route('members.index') }}" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-submit">Enregistrer</button>
        </div>
    </form>
</div>

<style>
/* WRAPPER */
.form-wrapper {
    display: flex;
    justify-content: center;
    padding: 40px 0;
}

/* FORM CARD */
.member-form {
    background: #ffffff;
    width: 100%;
    max-width: 850px;
    padding: 35px 40px;
    border-radius: 18px;
    border: 1px solid var(--border-soft);
    box-shadow: 0 12px 35px rgba(0,0,0,0.08);
}

/* TITRE */
.form-title {
    text-align: center;
    color: var(--blue);
    font-size: 24px;
    margin-bottom: 30px;
}

/* CONTENU */
.form-body {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* GROUPE */
.form-group label {
    display: block;
    font-size: 14px;
    margin-bottom: 6px;
    color: var(--black);
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 11px 14px;
    border-radius: 10px;
    border: 1px solid var(--border-soft);
    font-size: 14px;
    outline: none;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: var(--blue);
}

/* LIGNE (2 COLONNES) */
.form-row {
    display: flex;
    gap: 20px;
}

.form-row .form-group {
    flex: 1;
}

/* ERREURS */
.error {
    display: block;
    color: var(--red);
    font-size: 12px;
    margin-top: 4px;
}

/* BOUTONS */
.form-buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 35px;
}

.btn-cancel {
    background: #e5e7eb;
    color: var(--black);
    padding: 12px 24px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 14px;
}

.btn-cancel:hover {
    background: #d1d5db;
}

.btn-submit {
    background: var(--green);
    color: #ffffff;
    padding: 12px 28px;
    border-radius: 10px;
    border: none;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
}

.btn-submit:hover {
    background: #168a4a;
}

/* APERCU PHOTO */
.img-preview {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 12px;
    border: 2px solid var(--blue);
    margin-bottom: 10px;
}

/* PETIT ESPACEMENT */
.mb-2 {
    margin-bottom: 10px;
}


/* RESPONSIVE */
@media (max-width: 768px) {
    .member-form {
        padding: 25px;
    }

    .form-row {
        flex-direction: column;
    }

    .form-buttons {
        flex-direction: column;
        gap: 15px;
    }

    .btn-cancel,
    .btn-submit {
        width: 100%;
        text-align: center;
    }
}</style>
@endsection
