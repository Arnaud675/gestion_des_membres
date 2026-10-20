<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'EEJ-C Admin') - Gestion des membres</title>
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('assets/LogoEEJC.jpeg') }}" alt="Logo Église des Envoyés de Jésus-Christ">
                <h3>EEJ-C Admin</h3>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </span>
                        <span>Accueil</span>
                    </a>
                </li>

                @auth
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </span>
                        <span>Tableau de bord</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('members.index') }}" class="{{ request()->routeIs('members.*') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </span>
                        <span>Membres</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('cotisations.index') }}" class="{{ request()->routeIs('cotisations.*') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                                <line x1="2" y1="10" x2="22" y2="10"></line>
                            </svg>
                        </span>
                        <span>Cotisations</span>
                    </a>
                </li>

                <li>
    <a href="{{ route('depenses.index') }}" class="{{ request()->routeIs('depenses.*') ? 'active' : '' }}">
        <span class="menu-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
            </svg>
        </span>
        <span>Dépenses</span>
    </a>
</li>
                @endauth
            </ul>

            @auth
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <span class="user-role">{{ Auth::user()->isAdmin() ? 'Administrateur' : 'Utilisateur' }}</span>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
            @endauth
        </aside>

        <!-- CONTENU PRINCIPAL -->
        <main class="dashboard-main">
            @yield('content')
        </main>
    </div>

    <!-- Toast notifications -->
    <div id="toast-container"></div>

    <script src="{{ asset('js/toast.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            showToast(@json(session('success')), 'success');
        @endif

        @if(session('error'))
            showToast(@json(session('error')), 'error');
        @endif

        @if(session('warning'))
            showToast(@json(session('warning')), 'warning');
        @endif

        @if(session('info'))
            showToast(@json(session('info')), 'info');
        @endif
    });
    </script>

    @stack('scripts')
</body>
</html>