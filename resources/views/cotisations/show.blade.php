@extends('layouts.app')

@section('content')
<div class="table-wrapper">

    <h3>Cotisations de {{ $member->nom }} {{ $member->prenom }}</h3>

    <a href="{{ route('cotisations.index') }}" class="btn-back mb-3">← Retour</a>

    @php
        $moisNoms = [
            1 => 'Janvier',
            2 => 'Février',
            3 => 'Mars',
            4 => 'Avril',
            5 => 'Mai',
            6 => 'Juin',
            7 => 'Juillet',
            8 => 'Août',
            9 => 'Septembre',
            10 => 'Octobre',
            11 => 'Novembre',
            12 => 'Décembre'
        ];
    @endphp

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
                    <td>{{ $moisNoms[$cotisation->mois] ?? $cotisation->mois }}</td>
                    <td>{{ $cotisation->annee }}</td>
                    <td>{{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA</td>
                    <td>{{ \Carbon\Carbon::parse($cotisation->date_paiement)->format('d/m/Y') }}</td>
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
/* WRAPPER */
.table-wrapper {
    padding: 20px 10px;
}

/* TITRE */
.table-wrapper h3 {
    color: var(--blue);
    font-size: 24px;
    margin-bottom: 15px;
}

/* BOUTON RETOUR */
.btn-back {
    display: inline-block;
    background: #e5e7eb;
    color: var(--black);
    padding: 10px 18px;
    border-radius: 10px;
    text-decoration: none;
    margin-bottom: 20px;
    font-size: 14px;
}

.btn-back:hover {
    background: #d1d5db;
}

/* TABLE */
.table-cotisations {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 12px 30px rgba(0,0,0,0.06);
}

/* EN-TÊTE */
.table-cotisations thead {
    background: #f1f2f6;
}

.table-cotisations thead th {
    padding: 12px 10px;
    text-align: left;
    font-size: 14px;
    color: #555;
}

/* LIGNES */
.table-cotisations tbody tr {
    transition: 0.2s;
}

.table-cotisations tbody tr:hover {
    background: #f8fafc;
}

/* CELLULES */
.table-cotisations tbody td {
    padding: 12px 10px;
    font-size: 14px;
    color: #333;
}

/* BADGES */
.badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 500;
    color: #fff;
    text-align: center;
}

.bg-success {
    background: var(--green);
}

.bg-warning {
    background: #f1c40f;
    color: #111;
}

/* RESPONSIVE TABLE */
@media (max-width: 768px) {
    .table-cotisations thead {
        display: none;
    }

    .table-cotisations,
    .table-cotisations tbody,
    .table-cotisations tr,
    .table-cotisations td {
        display: block;
        width: 100%;
    }

    .table-cotisations tr {
        margin-bottom: 15px;
        border: 1px solid var(--border-soft);
        border-radius: 12px;
        padding: 10px;
    }

    .table-cotisations td {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
    }

    .table-cotisations td::before {
        content: attr(data-label);
        font-weight: 500;
        color: #555;
        width: 45%;
    }
}

</style>
@endsection
