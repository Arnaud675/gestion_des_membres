@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajouter un membre</h2>

    <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" class="form-control" name="nom" required>
            @error('nom') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Prénoms</label>
            <input type="text" class="form-control" name="prenoms" required>
            @error('prenoms') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Date de naissance</label>
                <input type="date" class="form-control" name="date_naissance" required>
                @error('date_naissance') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Lieu de naissance</label>
                <input type="text" class="form-control" name="lieu_naissance" required>
                @error('lieu_naissance') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Nom du père</label>
            <input type="text" class="form-control" name="nom_pere">
            @error('nom_pere') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Nom de la mère</label>
            <input type="text" class="form-control" name="nom_mere">
            @error('nom_mere') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Profession</label>
            <input type="text" class="form-control" name="profession">
            @error('profession') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Nationalité</label>
            <input type="text" class="form-control" name="nationalite">
            @error('nationalite') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Situation Matrimoniale</label>
            <select class="form-control" name="situation_matrimoniale">
                <option value="">-- Sélectionnez --</option>
                <option value="célibataire">Célibataire</option>
                <option value="marié(e)">Marié(e)</option>
                <option value="divorcé(e)">Divorcé(e)</option>
                <option value="veuf(ve)">Veuf(ve)</option>
            </select>
            @error('situation_matrimoniale') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Adresse complète</label>
            <textarea class="form-control" name="adresse" rows="3"></textarea>
            @error('adresse') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- 🔥 Champ photo ajouté --}}
        <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" class="form-control" name="photo" accept="image/*">
            @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('members.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
