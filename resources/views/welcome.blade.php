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
       /* COULEURS DU LOGO */
:root {
    --blue: #1f4fd8;
    --green: #1fa85b;
    --yellow: #f2c200;
    --red: #d62828;
    --black: #111111;

    --bg-light: #f7f9fc;
    --border-soft: #e4e7ec;
}

/* CONTENEUR */
.home-container {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: var(--bg-light);
}

/* CARD PRINCIPALE */
.home-card {
    background: #ffffff;
    max-width: 700px;
    padding: 45px;
    border-radius: 20px;
    border: 1px solid var(--border-soft);
    text-align: center;
    box-shadow: 0 12px 35px rgba(0,0,0,0.08);
}

/* TITRE */
.home-title {
    font-size: 28px;
    color: var(--black);
    margin-bottom: 20px;
    line-height: 1.4;
}

.home-title span {
    display: block;
    margin-top: 10px;
    color: var(--blue);
    font-weight: 600;
}

/* TEXTE */
.home-text {
    font-size: 16px;
    color: #555;
    margin-bottom: 25px;
}

/* CONNECTÉ */
.home-connected {
    font-size: 16px;
    color: var(--green);
    margin-bottom: 25px;
    font-weight: 500;
}

/* BOUTON */
.btn-home {
    display: inline-block;
    padding: 14px 28px;
    border-radius: 12px;
    background: var(--green);
    color: #ffffff;
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
    transition: 0.25s;
}

.btn-home:hover {
    background: #168a4a;
}

    </style>