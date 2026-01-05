@extends('layouts.app')

@section('content')
<div class="table-wrapper">

    <h3>Liste des cotisations</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('cotisations.create') }}" class="btn-new mb-3">Nouvelle cotisation</a>

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
                    <td>{{ $cotisation->mois }}</td>
                    <td>{{ $cotisation->annee }}</td>
                    <td>{{ $cotisation->montant }}</td>
                    <td>{{ $cotisation->date_paiement }}</td>
                    <td>
                        <form action="{{ route('cotisations.destroy', $cotisation->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn-delete" onclick="return confirm('Supprimer cette cotisation ?')">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
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

.btn-new {
    display: inline-block;
    padding: 8px 18px;
    border-radius: 30px;
    background: linear-gradient(135deg, #f4c430, #1e5aa8);
    color: #fff;
    text-decoration: none;
}

.btn-new:hover {
    background: linear-gradient(135deg, #1e5aa8, #2e8b57);
    transform: translateY(-2px);
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
    background-color: #1e5aa8;
    color: #fff;
    font-weight: 500;
}

.btn-delete {
    padding: 5px 12px;
    border-radius: 20px;
    background: #dc3545;
    color: #fff;
    border: none;
    cursor: pointer;
}

.btn-delete:hover {
    background: #c82333;
}
</style>
@endsection
