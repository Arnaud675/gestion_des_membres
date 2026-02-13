@extends('layouts.app')

@section('content')
<div class="table-wrapper">

    <h3>Liste des cotisations</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(!auth()->user()->isAdmin())
        <a href="{{ route('cotisations.create') }}" class="btn-new mb-3">Nouvelle cotisation</a>
    @endif

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
                <th>Membre</th>
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
                    <td>{{ $cotisation->member->nom }} {{ $cotisation->member->prenom }}</td>
                    <td>{{ $moisNoms[$cotisation->mois] ?? $cotisation->mois }}</td>
                    <td>{{ $cotisation->annee }}</td>
                    <td>{{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA</td>
                    <td>{{ \Carbon\Carbon::parse($cotisation->date_paiement)->format('d/m/Y') }}</td>
                    <td>
                        @if(!auth()->user()->isAdmin())
                            <a href="{{ route('cotisations.edit', $cotisation->id) }}" class="btn-edit">Modifier</a>
                            <form action="{{ route('cotisations.destroy', $cotisation->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn-delete" onclick="return confirm('Supprimer cette cotisation ?')">
                                    Supprimer
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
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

/* MESSAGE SUCCÈS */
.alert-success {
    background: #e9f7ef;
    color: var(--green);
    padding: 12px 18px;
    border-radius: 10px;
    margin-bottom: 15px;
    border: 1px solid #cdeedb;
}

/* BOUTON NOUVELLE COTISATION */
.btn-new {
    display: inline-block;
    background: var(--green);
    color: #fff;
    padding: 10px 20px;
    border-radius: 12px;
    text-decoration: none;
    margin-bottom: 20px;
    font-weight: 500;
}

.btn-new:hover {
    background: #168a4a;
}

/* CARD TABLE */
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

/* BOUTON SUPPRIMER */
.btn-delete {
    background: var(--red);
    color: #fff;
    padding: 6px 12px;
    border-radius: 8px;
    border: none;
    font-size: 13px;
    cursor: pointer;
}

.btn-delete:hover {
    background: #b91f1f;
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
