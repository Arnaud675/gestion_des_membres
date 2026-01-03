@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Liste des cotisations</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('cotisations.create') }}" class="btn btn-primary mb-3">
        Nouvelle cotisation
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>member</th>
                <th>Mois</th>
                <th>Année</th>
                <th>Montant</th>
                <th>Date paiement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cotisations as $cotisation)
                <tr>
                    <td>
                        {{ $cotisation->member->nom }}
                        {{ $cotisation->member->prenom }}
                    </td>
                    <td>{{ $cotisation->mois }}</td>
                    <td>{{ $cotisation->annee }}</td>
                    <td>{{ $cotisation->montant }}</td>
                    <td>{{ $cotisation->date_paiement }}</td>
                    <td>
                        <form action="{{ route('cotisations.destroy', $cotisation->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Supprimer cette cotisation ?')">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
