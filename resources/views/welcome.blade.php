@extends('layouts.app')

@section('content')
    
<h1>Bienvenue sur le site de gestion des membres de L'Eglise Des Envoyés de Jesus-Christ</h1>

{{-- <p>Veillez vous connectez</p> --}}


 @if (Auth::user())
     Vous etes deja connecté
 @else
     <a href="{{route('login')}}">Se connecter</a>
 @endif
@endsection


