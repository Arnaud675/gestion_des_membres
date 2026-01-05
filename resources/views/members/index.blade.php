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
/* body {
    background: linear-gradient(135deg, #1e5aa8, #2e8b57);
    font-family: "Poppins", sans-serif;
    margin: 0;
    padding: 0;
} */

.members-wrapper {
    padding: 20px;
}

.header h2 {
    color: #ffffff;
}

.btn-add {
    background: linear-gradient(135deg, #f4c430, #1e5aa8);
    color: #fff;
    padding: 10px 18px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
}

.btn-add:hover {
    background: linear-gradient(135deg, #1e5aa8, #2e8b57);
    transform: translateY(-2px);
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    padding: 12px 15px;
    border-radius: 8px;
    margin-bottom: 15px;
}

.members-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    overflow-x: auto;
}

.members-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

.members-table th,
.members-table td {
    padding: 12px 15px;
    border-bottom: 1px solid #ddd;
    vertical-align: middle;
}

.members-table thead {
    background-color: #1e5aa8;
    color: #fff;
}

.member-img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
}

.actions a,
.actions button {
    margin-right: 5px;
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
    border: none;
    cursor: pointer;
    text-decoration: none;
}

.btn-view {
    background-color: #17a2b8;
    color: #fff;
}

.btn-view:hover {
    background-color: #138496;
}

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

.pagination-wrapper {
    margin-top: 15px;
    text-align: center;
}

.pagination-wrapper .page-link {
    color: #1e5aa8;
}

.pagination-wrapper .page-item.active .page-link {
    background-color: #1e5aa8;
    border-color: #1e5aa8;
    color: #fff;
}

.text-muted {
    color: #6c757d;
}
</style>
@endsection
