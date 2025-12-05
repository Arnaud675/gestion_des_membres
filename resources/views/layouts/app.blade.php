<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestion des Membres')</title>

    
</head>

<body>

    
    <nav class="">
        <div class="container">

            <a class="" href="{{ route('welcome') }}">
                
                <img src="logo.png" alt="Logo EEJ-C" width="8%" >
            </a>


            {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button> --}}

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <!-- Accueil -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('welcome') }}">Accueil</a>
                    </li>

                    <!-- Liste des membres (si connecté) -->
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('members.index') }}">
                            Liste des membres
                        </a>
                    </li>
                    @endauth

                </ul>

                <!-- Partie droite de la navbar -->
                <ul class="navbar-nav ms-auto">

                    @guest
                        <!-- Lien Login -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                        </li>
                    @endguest

                    @auth
                        <!-- Texte utilisateur -->
                        <li class="nav-item">
                            <span class="nav-link text-white">
                                Bonjour, {{ Auth::user()->name }}
                            </span>
                        </li>

                        <!-- Bouton Déconnexion -->
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="btn btn-danger btn-sm">
                                    Se déconnecter
                                </button>
                            </form>
                        </li>
                    @endauth

                </ul>
            </div>
        </div>
    </nav>

    
    <div class="
    <!-- Bootstra">
        @yield('content')
    </div>

    
    

</body>
</html>
