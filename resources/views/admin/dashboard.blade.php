@extends('layouts.app')

@section('content')
    
<div class="container mt-4">
    <h1>Dashboard Agriculteur</h1>
    <p>Bienvenue {{ auth()->user()->name }} !</p>

    {{-- <form action="{{ route('logout') }}" method="POST">
    @csrf --}}
    {{-- <button type="submit" class="btn btn-danger">
        Se déconnecter
    </button> --}}
</form>


<a href="{{route('members.create')}}">Ajouter un membre</a>

   

    
</div>

@endsection

