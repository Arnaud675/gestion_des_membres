<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'EEJ-C Admin')</title>

    
<style>
/* RESET */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}

/* COULEURS DU LOGO */
:root {
    --blue: #1f4fd8;
    --green: #1fa85b;
    --yellow: #f2c200;
    --black: #111111;
    --red: #d62828;

    --bg-light: #f7f9fc;
    --sidebar-bg: #111111;
    --sidebar-block: #1a1a1a;
    --text-light: #ffffff;
    --border-soft: #e4e7ec;
}

/* BODY */
body {
    background: var(--bg-light);
}

/* LAYOUT */
.dashboard-container {
    display: flex;
    min-height: 100vh;
}

/* =======================
   SIDEBAR EN BLOCS
======================= */
.sidebar {
    width: 260px;
    background: var(--sidebar-bg);
    color: var(--text-light);
    padding: 25px 18px;
    position: sticky;
    top: 0;
    height: 100vh;
}

/* HEADER */
.sidebar-header {
    background: var(--sidebar-block);
    border-radius: 14px;
    padding: 18px;
    text-align: center;
    margin-bottom: 30px;
    border: 1px solid var(--blue);
}

.sidebar-header img {
    width: 100px;
    margin-bottom: 10px;
    border-radius: 10px;
}

.sidebar-header h3 {
    color: var(--blue);
    font-size: 18px;
}

/* MENU */
.sidebar-menu {
    list-style: none;
}

.sidebar-menu li a {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--sidebar-block);
    color: var(--text-light);
    text-decoration: none;
    padding: 12px 16px;
    border-radius: 10px;
    margin-bottom: 12px;
    border-left: 4px solid transparent;
    transition: 0.25s;
}

.sidebar-menu li a:hover {
    background: #222;
    border-left: 4px solid var(--yellow);
}

.sidebar-menu li a.active {
    background: var(--green);
    color: #fff;
    border-left: 4px solid var(--yellow);
}

/* FOOTER UTILISATEUR */
.sidebar-footer {
    margin-top: 40px;
    background: var(--sidebar-block);
    border-radius: 14px;
    padding: 15px;
    text-align: center;
    border: 1px solid var(--yellow);
    font-size: 14px;
}

/* BOUTON DECONNEXION */
.btn-logout {
    margin-top: 12px;
    padding: 10px;
    border: none;
    border-radius: 8px;
    background: var(--red);
    color: white;
    cursor: pointer;
    width: 100%;
    font-weight: 500;
}

.btn-logout:hover {
    background: #b91f1f;
}

/* =======================
   CONTENU EN BLOCS
======================= */
.dashboard-main {
    flex: 1;
    padding: 40px;
}

/* BLOCS REUTILISABLES */
.card {
    background: #ffffff;
    border-radius: 16px;
    padding: 25px;
    border: 1px solid var(--border-soft);
    margin-bottom: 25px;
}

.card h2 {
    color: var(--blue);
    margin-bottom: 15px;
}
</style>


    
</head>
<body>

<div class="dashboard-container">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="sidebar-header">
            <img src="{{ asset('assets/LogoEEJC.jpeg') }}" alt="Logo EEJ-C">
            <h3>EEJ-C Admin</h3>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('welcome') }}"
                   class="{{ request()->routeIs('welcome') ? 'active' : '' }}">
                     Accueil
                </a>
            </li>

            @auth
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                     Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('members.index') }}"
                   class="{{ request()->routeIs('members.*') ? 'active' : '' }}">
                     Membres
                </a>
            </li>

            <li>
                <a href="{{ route('cotisations.index') }}"
                   class="{{ request()->routeIs('cotisations.*') ? 'active' : '' }}">
                     Cotisations
                </a>
            </li>
            @endauth
        </ul>

        @auth
        <div class="sidebar-footer">
            <div>{{ Auth::user()->name }}</div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn-logout">Déconnexion</button>
            </form>
        </div>
        @endauth

    </aside>

    <!-- CONTENU -->
    <main class="dashboard-main">
        @yield('content')
    </main>

</div>

</body>
</html>