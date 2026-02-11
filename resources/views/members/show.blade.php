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
                        @if(!auth()->user()->isAdmin())
                            <a href="{{ route('members.edit', $member->id) }}" class="btn-edit">Modifier</a>

                            <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Voulez-vous vraiment supprimer ce membre ?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn-delete">Supprimer</button>
                            </form>
                        @endif
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
/* WRAPPER */
.member-details-wrapper {
    padding: 20px 10px;
}

/* HEADER */
.member-details-wrapper .header h2 {
    color: var(--blue);
    font-size: 24px;
    margin-bottom: 15px;
}

/* CARD */
.details-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid var(--border-soft);
    padding: 25px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.06);
}

/* PHOTO */
.member-photo {
    width: 160px;
    height: 160px;
    object-fit: cover;
    border-radius: 12px;
    border: 2px solid var(--blue);
}

/* NOM DU MEMBRE */
.member-name {
    color: var(--black);
    font-size: 22px;
    font-weight: 600;
}

/* TABLEAU INFO */
.member-info-table {
    width: 100%;
    margin-top: 15px;
    border-collapse: collapse;
    font-size: 14px;
}

.member-info-table th {
    text-align: left;
    color: #555;
    padding: 8px 12px;
    width: 40%;
}

.member-info-table td {
    color: #333;
    padding: 8px 12px;
}

/* BOUTONS ACTIONS */
.btn-edit {
    background: var(--yellow);
    color: var(--black);
    padding: 8px 16px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 14px;
    margin-right: 8px;
    margin-top: 25px;
}

.btn-edit:hover {
    background: #e6b800;
}

.btn-delete {
    background: var(--red);
    color: #fff;
    padding: 8px 16px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    margin-top: 20px;
}

.btn-delete:hover {
    background: #b91f1f;
}

/* BOUTONS DE NAVIGATION */
.btn-back {
    display: inline-block;
    margin-right: 10px;
    padding: 8px 16px;
    border-radius: 10px;
    background: #e5e7eb;
    color: var(--black);
    text-decoration: none;
    font-size: 14px;
    margin-top: 20px;
}

.btn-back:hover {
    background: #d1d5db;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .details-card .row {
        flex-direction: column;
    }

    .member-photo {
        margin-bottom: 20px;
        margin-left: auto;
        margin-right: auto;
    }
}

</style>
@endsection
