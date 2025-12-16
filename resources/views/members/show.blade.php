@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Détails du membre</h2>
    
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="row">

                {{-- Photo --}}
                <div class="col-md-4 text-center mb-4">
                    @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" alt="photo"
                             class="img-fluid rounded border" style="max-width: 250px;">
                    @else
                        <div class="text-muted">Aucune photo disponible</div>
                    @endif
                </div>

                {{-- Infos --}}
                <div class="col-md-8">
                    <h4 class="mb-3">{{ $member->nom }} {{ $member->prenoms }}</h4>

                    <table class="table table-bordered">
                        <tr><th>Date de naissance :</th><td>{{ $member->date_naissance }}</td></tr>
                        <tr><th>Lieu de naissance :</th><td>{{ $member->lieu_naissance }}</td></tr>
                        <tr><th>Nom du père :</th><td>{{ $member->nom_pere ?? '-' }}</td></tr>
                        <tr><th>Nom de la mère :</th><td>{{ $member->nom_mere ?? '-' }}</td></tr>
                        <tr><th>Profession :</th><td>{{ $member->profession ?? '-' }}</td></tr>
                        <tr><th>Nationalité :</th><td>{{ $member->nationalite ?? '-' }}</td></tr>
                        <tr><th>Situation matrimoniale :</th><td>{{ $member->situation_matrimoniale ?? '-' }}</td></tr>
                        <tr><th>Adresse :</th><td>{{ $member->adresse ?? '-' }}</td></tr>
                    </table>

                    <div class="mt-3">
                        <a href="{{ route('members.edit', $member->id) }}" class="btn btn-primary">Modifier</a>

                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Voulez-vous vraiment supprimer ce membre ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Supprimer</button>
                        </form>
                    </div>

                </div>
                <a href="{{ route('members.index') }}" class="btn btn-secondary">← Retour</a>
            </div>

        </div>
    </div>

</div>
@endsection
