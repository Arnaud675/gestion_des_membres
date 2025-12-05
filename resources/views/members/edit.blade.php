@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier le membre</h2>

    <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" class="form-control" name="name" value="{{ $member->name }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ $member->email }}" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Téléphone</label>
            <input type="text" class="form-control" name="phone" value="{{ $member->phone }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Nouvelle photo (optionnel)</label>
            <input type="file" class="form-control" name="photo">

            @if($member->photo)
                <p class="mt-2">Photo actuelle :</p>
                <img src="{{ asset('storage/' . $member->photo) }}" width="100" class="rounded">
            @endif

            @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('members.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
