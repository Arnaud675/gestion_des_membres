@extends('layouts.app')

@section('content')
<div class="form-wrapper">
    <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data" class="member-form">
        @csrf

        <h2 class="form-title">Ajouter un membre</h2>

        <div class="form-body">
            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="nom" required>
                @error('nom') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Prénoms</label>
                <input type="text" name="prenoms" required>
                @error('prenoms') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Date de naissance</label>
                    <input type="date" name="date_naissance" required>
                    @error('date_naissance') <small class="error">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>Lieu de naissance</label>
                    <input type="text" name="lieu_naissance" required>
                    @error('lieu_naissance') <small class="error">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Nom du père</label>
                <input type="text" name="nom_pere">
                @error('nom_pere') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Nom de la mère</label>
                <input type="text" name="nom_mere">
                @error('nom_mere') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Profession</label>
                <input type="text" name="profession">
                @error('profession') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Nationalité</label>
                <input type="text" name="nationalite">
                @error('nationalite') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Situation Matrimoniale</label>
                <select name="situation_matrimoniale">
                    <option value="">-- Sélectionnez --</option>
                    <option value="célibataire">Célibataire</option>
                    <option value="marié(e)">Marié(e)</option>
                    <option value="divorcé(e)">Divorcé(e)</option>
                    <option value="veuf(ve)">Veuf(ve)</option>
                </select>
                @error('situation_matrimoniale') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Adresse complète</label>
                <textarea name="adresse" rows="3"></textarea>
                @error('adresse') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Photo</label>
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
/* body {
    background: linear-gradient(135deg, #1e5aa8, #2e8b57);
    font-family: "Poppins", sans-serif;
    margin: 0;
    padding: 0;
} */

/* ===== CONTAINER ===== */
.form-wrapper {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 20px;
    height: 100vh;
}

/* ===== FORMULAIRE ===== */
.member-form {
    background: #ffffff;
    width: 500px;
    border-radius: 16px;
    padding: 30px;
    border-top: 6px solid #f4c430;
    box-shadow: 0 20px 45px rgba(0,0,0,0.25);

    display: flex;
    flex-direction: column;
    max-height: calc(100vh - 40px); /* Hauteur max pour rester dans la sidebar */
}

.form-title {
    text-align: center;
    margin-bottom: 20px;
    color: #1e5aa8;
    font-size: 24px;
    font-weight: 600;
}

.form-body {
    overflow-y: auto; /* Scroll si formulaire trop long */
    flex: 1;
    padding-right: 5px; /* pour scrollbar */
}

.form-row {
    display: flex;
    gap: 10px;
}

.form-row .form-group {
    flex: 1; /* deux champs côte à côte avec même largeur */
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
    box-sizing: border-box; /* fixe la largeur */
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: #2e8b57;
    box-shadow: 0 0 6px rgba(46,139,87,0.4);
}

/* ===== BOUTONS ===== */
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

/* ===== ERREURS ===== */
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
