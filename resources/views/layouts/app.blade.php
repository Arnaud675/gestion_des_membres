<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestion des Membres')</title>

    <style>
        /* ===== BASE ===== */
        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            background: #f4f6f9;
        }

        /* ===== LAYOUT ===== */
        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #1e5aa8, #2e8b57);
            color: #ffffff;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            text-align: center;
            padding: 25px 15px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .sidebar-header img {
            width: 80px;
            margin-bottom: 10px;
        }

        .sidebar-header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
            margin: 0;
            flex: 1;
        }

        .sidebar-menu li {
            margin-bottom: 8px;
        }

        .sidebar-menu a {
            display: block;
            padding: 12px 25px;
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .sidebar-menu a:hover {
            background: rgba(255,255,255,0.15);
            border-left: 4px solid #f4c430;
        }

        /* ===== FOOTER SIDEBAR ===== */
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.2);
            text-align: center;
            font-size: 14px;
        }

        .btn-logout {
            margin-top: 10px;
            background: #e74c3c;
            color: #ffffff;
            border: none;
            padding: 8px 18px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-logout:hover {
            background: #c0392b;
        }

        /* ===== CONTENU ===== */
        .content {
            flex: 1;
            padding: 30px;
        }

        .card {
            background: #ffffff;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            border-top: 6px solid #f4c430;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
        }
    </style>
</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="sidebar-header">
            <img src="logo.png" alt="Logo EEJ-C">
            <h3>EEJ-C Admin</h3>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('welcome') }}">🏠 Accueil</a>
            </li>

            @auth
            <li>
                <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
            </li>

            <li>
                <a href="{{ route('members.index') }}">👥 Membres</a>
            </li>
            <li>
                <a href="{{ route('cotisations.index') }}">💰 Cotisations</a>
            </li>
            @endauth
        </ul>

        <div class="sidebar-footer">
            @auth
                <div>{{ Auth::user()->name }}</div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn-logout">Déconnexion</button>
                </form>
            @endauth
        </div>

    </aside>

    <!-- CONTENU -->
    <main class="content">
        @yield('content')
    </main>

</div>

</body>
</html>
