@extends('layouts.app')

@section('content')
<div class="members-wrapper">

    <div class="header d-flex justify-content-between align-items-center mb-4">
        <h2>Liste des membres</h2>
        <a href="{{ route('members.create') }}" class="btn-add">
            + Ajouter un membre
        </a>
    </div>

    {{-- Message succès --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="members-card">
        <table class="members-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Nom & Prénoms</th>
                    <th>Date de naissance</th>
                    <th>Profession</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($members as $member)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td class="text-center">
                            @if($member->photo)
                                <img src="{{ asset('storage/' . $member->photo) }}"
                                     alt="photo"
                                     class="member-img">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        <td>{{ $member->nom }} {{ $member->prenoms }}</td>
                        <td>{{ $member->date_naissance }}</td>
                        <td>{{ $member->profession ?? '-' }}</td>

                        <td class="actions">
                            <a href="{{ route('members.show', $member->id) }}" class="btn-view">Voir</a>
                            <a href="{{ route('members.edit', $member->id) }}" class="btn-edit">Modifier</a>

                            <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer ce membre ?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn-delete">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Aucun membre enregistré
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if(method_exists($members, 'links'))
            <div class="pagination-wrapper">
                {{ $members->links() }}
            </div>
        @endif
    </div>
</div>

<style>
/* WRAPPER */
.members-wrapper {
    padding: 20px 10px;
}

/* HEADER */
.members-wrapper .header h2 {
    color: var(--blue);
    font-size: 24px;
}

/* BOUTON AJOUT */
.btn-add {
    background: var(--green);
    color: #fff;
    padding: 12px 22px;
    border-radius: 12px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

.btn-add:hover {
    background: #168a4a;
}

/* MESSAGE SUCCÈS */
.alert-success {
    background: #e9f7ef;
    color: var(--green);
    padding: 12px 18px;
    border-radius: 10px;
    margin-bottom: 20px;
    border: 1px solid #cdeedb;
}

/* CARD TABLE */
.members-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid var(--border-soft);
    padding: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    margin-top: 20px;
}

/* TABLE */
.members-table {
    width: 100%;
    border-collapse: collapse;
}

/* EN-TÊTE */
.members-table thead th {
    text-align: left;
    font-size: 14px;
    color: #555;
    padding: 12px 10px;
    border-bottom: 2px solid var(--border-soft);
}

/* LIGNES */
.members-table tbody tr {
    transition: 0.2s;
}

.members-table tbody tr:hover {
    background: #f8fafc;
}

/* CELLULES */
.members-table td {
    padding: 14px 10px;
    font-size: 14px;
    color: #333;
    vertical-align: middle;
}

/* IMAGE */
.member-img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--blue);
}

/* ACTIONS */
.actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: 10px;
}

/* BOUTONS */
.btn-view {
    background: var(--blue);
    color: #fff;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 13px;
    text-decoration: none;
}

.btn-edit {
    background: var(--yellow);
    color: var(--black);
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 13px;
    text-decoration: none;
}

.btn-delete {
    background: var(--red);
    color: #fff;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 13px;
    border: none;
    cursor: pointer;
}

/* PAGINATION */
.pagination-wrapper {
    margin-top: 20px;
    display: flex;
    justify-content: center;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .members-table thead {
        display: none;
    }

    .members-table,
    .members-table tbody,
    .members-table tr,
    .members-table td {
        display: block;
        width: 100%;
    }

    .members-table tr {
        margin-bottom: 15px;
        border: 1px solid var(--border-soft);
        border-radius: 12px;
        padding: 10px;
    }

    .members-table td {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
    }

    .members-table td::before {
        content: attr(data-label);
        font-weight: 500;
        color: #555;
    }

    .actions {
        justify-content: flex-end;
        
    }
}

</style>
@endsection
