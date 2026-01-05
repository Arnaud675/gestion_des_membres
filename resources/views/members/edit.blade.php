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
body {
    background: linear-gradient(135deg, #1e5aa8, #2e8b57);
    font-family: "Poppins", sans-serif;
    margin: 0;
    padding: 0;
}

.form-wrapper {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 20px;
    height: 100vh;
}

.member-form {
    background: #ffffff;
    width: 500px;
    border-radius: 16px;
    padding: 30px;
    border-top: 6px solid #f4c430;
    box-shadow: 0 20px 45px rgba(0,0,0,0.25);

    display: flex;
    flex-direction: column;
    max-height: calc(100vh - 40px);
}

.form-title {
    text-align: center;
    margin-bottom: 20px;
    color: #1e5aa8;
    font-size: 24px;
    font-weight: 600;
}

.form-body {
    overflow-y: auto;
    flex: 1;
    padding-right: 5px;
}

.form-row {
    display: flex;
    gap: 10px;
}

.form-row .form-group {
    flex: 1;
}

.form-group {
    margin-bottom: 15px;
    display: flex;
    flex-direction: column;
}

.form-group label {
    margin-bottom: 6px;
    font-weight: 500;
    color: #1c1c1c;
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 10px 12px;
    border-radius: 8px;
    border: 2px solid #1e5aa8;
    outline: none;
    font-size: 14px;
    transition: 0.3s;
    width: 100%;
    box-sizing: border-box;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: #2e8b57;
    box-shadow: 0 0 6px rgba(46,139,87,0.4);
}

.img-preview {
    max-width: 150px;
    border-radius: 8px;
}

.form-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 10px;
}

.btn-submit {
    padding: 12px 20px;
    background: linear-gradient(135deg, #f4c430, #1e5aa8);
    color: #ffffff;
    border: none;
    border-radius: 30px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.btn-submit:hover {
    background: linear-gradient(135deg, #1e5aa8, #2e8b57);
    transform: translateY(-2px);
}

.btn-cancel {
    padding: 12px 20px;
    background: #cccccc;
    color: #1c1c1c;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 500;
    text-align: center;
    transition: 0.3s;
}

.btn-cancel:hover {
    background: #999999;
    color: #ffffff;
}

.error {
    color: #e74c3c;
    font-size: 13px;
}

.form-body::-webkit-scrollbar {
    width: 6px;
}

.form-body::-webkit-scrollbar-thumb {
    background-color: rgba(30, 90, 168, 0.5);
    border-radius: 3px;
}
</style>
@endsection
