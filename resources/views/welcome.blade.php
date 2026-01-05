@extends('layouts.app')

@section('content')
<div class="home-container">
    <div class="home-card">

        <h1 class="home-title">
            Bienvenue sur le site de gestion des membres de  
            <span>L'Église des Envoyés de Jésus-Christ</span>
        </h1>

        @auth
            <p class="home-connected">✔ Vous êtes déjà connecté</p>
            <a href="{{ route('admin.dashboard') }}" class="btn-home">
                Tableau de bord
            </a>
        @else
            <p class="home-text">Veuillez vous connecter</p>
            <a href="{{ route('login') }}" class="btn-home">
                Se connecter
            </a>
        @endauth

    </div>
</div>
@endsection

 <style>
        body {
    background: linear-gradient(135deg, #1e5aa8, #2e8b57);
    font-family: "Poppins", sans-serif;
}

.home-container {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.home-card {
    background: #ffffff;
    padding: 40px;
    max-width: 700px;
    text-align: center;
    border-radius: 16px;
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
    border-top: 6px solid #f4c430;
}

.home-title {
    font-size: 26px;
    color: #1e5aa8;
    margin-bottom: 20px;
}

.home-title span {
    display: block;
    color: #2e8b57;
    margin-top: 8px;
    font-weight: 600;
}

.home-text {
    font-size: 16px;
    color: #1c1c1c;
    margin-bottom: 25px;
}

.home-connected {
    font-size: 18px;
    color: #2e8b57;
    font-weight: 600;
    margin-bottom: 25px;
}

.btn-home {
    display: inline-block;
    padding: 12px 30px;
    background: linear-gradient(135deg, #f4c430, #1e5aa8);
    color: #ffffff;
    text-decoration: none;
    border-radius: 30px;
    font-weight: bold;
    transition: 0.3s;
}

.btn-home:hover {
    background: linear-gradient(135deg, #1e5aa8, #2e8b57);
    transform: translateY(-3px);
}
    </style>