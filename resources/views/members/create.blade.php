@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajouter un membre</h2>

    <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" class="form-control" name="name" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Téléphone</label>
            <input type="text" class="form-control" name="phone">
        </div>

        <div class="mb-3">
            <label class="form-label">Photo de profil</label>
            <input type="file" class="form-control" name="photo">
            @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('members.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
