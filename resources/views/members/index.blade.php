@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Liste des membres</h2>
        <a href="{{ route('members.create') }}" class="btn btn-primary">Ajouter un membre</a>
    </div>

    @foreach($members as $member)
        <div class="card mb-3 shadow-sm">
            <div class="row g-0 align-items-center p-3">

                {{-- Photo --}}
                <div class="col-md-2 text-center">
                    @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" alt="photo"
                             class="img-fluid rounded border" style="max-width: 100px;">
                    @else
                        <div class="text-muted">Aucune photo</div>
                    @endif
                </div>

                {{-- Infos --}}
                <div class="col-md-8">
                    <h5>{{ $member->nom }} {{ $member->prenoms }}</h5>
                    <p class="mb-1"><strong>Date de naissance:</strong> {{ $member->date_naissance }}</p>
                    <p class="mb-1"><strong>Lieu de naissance:</strong> {{ $member->lieu_naissance }}</p>
                    <p class="mb-1"><strong>Profession:</strong> {{ $member->profession ?? '-' }}</p>
                    <p class="mb-1"><strong>Nationalité:</strong> {{ $member->nationalite ?? '-' }}</p>
                </div>

                {{-- Actions --}}
                <div class="col-md-2 text-center">
                    <a href="{{ route('members.show', $member->id) }}" class="btn btn-sm btn-info mb-1">Voir</a>
                    <a href="{{ route('members.edit', $member->id) }}" class="btn btn-sm btn-primary mb-1">Modifier</a>
                    <form action="{{ route('members.destroy', $member->id) }}" method="POST"
                          onsubmit="return confirm('Voulez-vous vraiment supprimer ce membre ?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Supprimer</button>
                    </form>
                </div>

            </div>

            {{-- Séparateur horizontal --}}
            <hr class="my-0">
        </div>
    @endforeach

</div>
@endsection
