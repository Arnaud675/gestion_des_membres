@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Détails du membre</h2>

    <div class="card mt-4">
        <div class="card-body text-center">

            @if($member->photo)
                <img src="{{ asset('storage/' . $member->photo) }}" 
                     width="150" height="150" class="rounded-circle mb-3" style="object-fit: cover;">
            @else
                <img src="https://via.placeholder.com/150" class="rounded-circle mb-3">
            @endif

            <h4>NOM : {{ $member->name }}</h4>
            <p><strong>Email :</strong> {{ $member->email }}</p>
            <p><strong>Téléphone :</strong> {{ $member->phone ?? 'Aucun' }}</p>

            <a href="{{ route('members.edit', $member->id) }}" class="btn btn-warning">Modifier</a>

            <form action="{{ route('members.destroy', $member->id) }}" 
                  method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Supprimer ce membre ?')" 
                        class="btn btn-danger">Supprimer</button>
            </form>

            <br><br>
            <a href="{{ route('members.index') }}" class="">Retour</a>
        </div>
    </div>
</div>
@endsection
