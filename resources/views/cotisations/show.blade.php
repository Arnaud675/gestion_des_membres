@extends('layouts.app')

@section('content')
<div class="container">
    <h3>
        Cotisations de {{ $membre->nom }} {{ $membre->prenom }}
    </h3>

    <a href="{{ route('cotisations.index') }}" class="btn btn-secondary mb-3">
        Retour
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mois</th>
                <th>Année</th>
                <th>Montant</th>
                <th>Date paiement</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($membre->cotisations as $cotisation)
                <tr>
                    <td>{{ $cotisation->mois }}</td>
                    <td>{{ $cotisation->annee }}</td>
                    <td>{{ $cotisation->montant }}</td>
                    <td>{{ $cotisation->date_paiement }}</td>
                    <td>
                        @if($cotisation->montant >= 1000)
                            <span class="badge bg-success">Payé</span>
                        @else
                            <span class="badge bg-warning">Incomplet</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Aucune cotisation trouvée
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
