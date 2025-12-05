@extends('layouts.app')

@section('content')
<h2>Liste des membres</h2>

<a href="{{ route('members.create') }}" class="btn btn-primary">Ajouter un membre</a>

<table class="table mt-3">
    <thead>
        <tr>
            <th>Photo</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($members as $member)
        <td><strong>{{ $member->id }}</strong></td> 
        <tr>
            <td>
                @if($member->photo)
                <img src="{{ asset('storage/' . $member->photo) }}" width="60" height="60" style="border-radius:50%;">
                @else
                -
                @endif
            </td>
            
            <td>{{ $member->name }}</td>
            <td>{{ $member->email }}</td>
            <td>{{ $member->phone }}</td>
            
            <td>
                <a href="{{ route('members.show', $member->id) }}" class="">Voir</a>
                <a href="{{ route('members.edit', $member->id) }}" class="">Modifier</a>

                <form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Supprimer ce membre ?')">Supprimer</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
