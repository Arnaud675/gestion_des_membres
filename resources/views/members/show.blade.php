@extends('layouts.app')

@section('content')
<div class="member-details-wrapper">

    <div class="header d-flex justify-content-between align-items-center mb-3">
        <h2>Détails du membre</h2>
    </div>

    <div class="details-card shadow-sm">
        <div class="details-body">

            <div class="row">

                {{-- Photo --}}
                <div class="col-md-4 text-center mb-4">
                    @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" alt="photo"
                             class="member-photo rounded border">
                    @else
                        <div class="text-muted">Aucune photo disponible</div>
                    @endif
                </div>

                {{-- Infos --}}
                <div class="col-md-8">
                    <h4 class="member-name mb-3">{{ $member->nom }} {{ $member->prenoms }}</h4>

                    <table class="member-info-table">
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
                        <a href="{{ route('members.edit', $member->id) }}" class="btn-edit">Modifier</a>

                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Voulez-vous vraiment supprimer ce membre ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn-delete">Supprimer</button>
                        </form>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('members.index') }}" class="btn-back">← Retour</a>
                        <a href="{{ route('members.cotisations', $member->id) }}" class="btn-back">Cotisations du membre</a>
                    </div>

                </div>

            </div>

        </div>
    </div>

</div>

<style>
.member-details-wrapper {
    padding: 20px;
}

.details-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.member-photo {
    max-width: 250px;
    width: 100%;
    height: auto;
    object-fit: cover;
}

.member-name {
    color: #1e5aa8;
    font-weight: 600;
}

.member-info-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.member-info-table th,
.member-info-table td {
    padding: 10px 12px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}

.member-info-table th {
    width: 40%;
    background-color: #f1f1f1;
    font-weight: 500;
}

.member-info-table td {
    color: #333;
}

.btn-edit, .btn-delete, .btn-back {
    display: inline-block;
    margin-right: 10px;
    margin-top: 5px;
    padding: 8px 18px;
    border-radius: 30px;
    font-weight: 500;
    font-size: 14px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: 0.3s;
}

/* Boutons modifier / supprimer */
.btn-edit {
    background-color: #007bff;
    color: #fff;
}

.btn-edit:hover {
    background-color: #0069d9;
}

.btn-delete {
    background-color: #dc3545;
    color: #fff;
}

.btn-delete:hover {
    background-color: #c82333;
}

/* Boutons retour / cotisations */
.btn-back {
    background: linear-gradient(135deg, #f4c430, #1e5aa8);
    color: #fff;
}

.btn-back:hover {
    background: linear-gradient(135deg, #1e5aa8, #2e8b57);
    transform: translateY(-2px);
}

.text-muted {
    color: #6c757d;
}
</style>
@endsection
