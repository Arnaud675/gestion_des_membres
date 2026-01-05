@extends('layouts.app')

@section('content')
<div class="table-wrapper">

    <h3>Cotisations de {{ $member->nom }} {{ $member->prenom }}</h3>

    <a href="{{ route('cotisations.index') }}" class="btn-back mb-3">← Retour</a>

    <table class="table-cotisations">
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
            @forelse($member->cotisations as $cotisation)
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
                    <td colspan="5" class="text-center">Aucune cotisation trouvée</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
.table-wrapper {
    background: #fff;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.btn-back {
    padding: 6px 16px;
    border-radius: 30px;
    background: #6c757d;
    color: #fff;
    text-decoration: none;
}

.btn-back:hover {
    background: #5a6268;
}

.table-cotisations {
    width: 100%;
    border-collapse: collapse;
}

.table-cotisations th, .table-cotisations td {
    border: 1px solid #ddd;
    padding: 10px 12px;
    text-align: left;
}

.table-cotisations th {
    background-color: #f1f1f1;
    font-weight: 500;
}

.badge.bg-success {
    background-color: #28a745;
    color: #fff;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
}

.badge.bg-warning {
    background-color: #ffc107;
    color: #212529;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
}
</style>
@endsection
