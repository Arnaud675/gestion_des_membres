@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Liste des membres</h2>
        <a href="{{ route('members.create') }}" class="btn btn-success">
            + Ajouter un membre
        </a>
    </div>

    {{-- Message succès --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
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
                                         class="rounded"
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td>
                                {{ $member->nom }} {{ $member->prenoms }}
                            </td>

                            <td>{{ $member->date_naissance }}</td>

                            <td>{{ $member->profession ?? '-' }}</td>

                            <td>
                                <a href="{{ route('members.show', $member->id) }}"
                                   class="btn btn-sm btn-info">
                                    Voir
                                </a>

                                <a href="{{ route('members.edit', $member->id) }}"
                                   class="btn btn-sm btn-primary">
                                    Modifier
                                </a>

                                <form action="{{ route('members.destroy', $member->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Voulez-vous vraiment supprimer ce membre ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        Supprimer
                                    </button>
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

            {{-- Pagination si utilisée --}}
            @if(method_exists($members, 'links'))
                <div class="mt-3">
                    {{ $members->links() }}
                </div>
            @endif

        </div>
    </div>

</div>
@endsection
