<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'EEJ-C') - Gestion des membres</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/LogoEEJC.jpeg') }}">
    
    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Centralized Dashboard Design System -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
    @stack('styles')
</head>
<body>
    <button type="button" class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Ouvrir le menu" aria-expanded="false">
        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
    </button>
    <button type="button" class="sidebar-overlay" id="sidebarOverlay" aria-label="Fermer le menu"></button>

    <div class="dashboard-container">
        <!-- SIDEBAR -->
        <aside class="sidebar" id="mainSidebar">
            <div class="sidebar-header">
                <a href="{{ route('welcome') }}" class="sidebar-brand-wrapper">
                    <img src="{{ asset('assets/LogoEEJC.jpeg') }}" alt="Logo EEJC">
                    <div class="sidebar-brand-text">
                        <h3>EEJ-C Admin</h3>
                        <span class="sidebar-brand-subtitle">Gestion d'Église</span>
                    </div>
                </a>
                <button type="button" class="sidebar-collapse-btn" id="sidebarCollapseBtn" aria-label="Réduire le menu" title="Réduire/Agrandir le menu">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
            </div>

            <!-- Recherche rapide dans le menu -->
            <div class="sidebar-search-container">
                <div class="sidebar-search-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" id="sidebarSearchInput" placeholder="Rechercher menu..." autocomplete="off">
                </div>
            </div>

            <!-- Section 1 : Navigation -->
            <div class="sidebar-section-title">Navigation</div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'active' : '' }}" data-title="Accueil">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </span>
                        <span class="menu-title">Accueil</span>
                    </a>
                </li>

                @auth
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-title="Tableau de bord">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </span>
                        <span class="menu-title">Tableau de bord</span>
                    </a>
                </li>
                @endauth
            </ul>

            @auth
            <!-- Section 2 : Gestion du ministère -->
            <div class="sidebar-section-title">Gestion du ministère</div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('members.index') }}" class="{{ request()->routeIs('members.index') || request()->routeIs('members.show') || request()->routeIs('members.create') || request()->routeIs('members.edit') ? 'active' : '' }}" data-title="Membres">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            </svg>
                        </span>
                        <span class="menu-title">Membres</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('cotisations.index') }}" class="{{ request()->routeIs('cotisations.index') || request()->routeIs('cotisations.create') || request()->routeIs('cotisations.edit') || request()->routeIs('cotisations.show') || request()->routeIs('members.cotisations') ? 'active' : '' }}" data-title="Cotisations">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                                <line x1="2" y1="10" x2="22" y2="10"></line>
                            </svg>
                        </span>
                        <span class="menu-title">Cotisations</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('cotisations.retards') }}" class="{{ request()->routeIs('cotisations.retards') ? 'active' : '' }}" data-title="Membres en retard">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="9"></circle>
                                <line x1="12" y1="7" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                        </span>
                        <span class="menu-title">Membres en retard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('depenses.index') }}" class="{{ request()->routeIs('depenses.*') ? 'active' : '' }}" data-title="Dépenses">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                            </svg>
                        </span>
                        <span class="menu-title">Dépenses</span>
                    </a>
                </li>
            </ul>

            @if(auth()->user()->isAdmin())
            <!-- Section 3 : Administration & Outils -->
            <div class="sidebar-section-title">Administration & Outils</div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('audit.index') }}" class="{{ request()->routeIs('audit.*') ? 'active' : '' }}" data-title="Historique des actions">
                        <span class="menu-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"></circle><polyline points="12 7 12 12 16 14"></polyline></svg></span>
                        <span class="menu-title">Historique des actions</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}" data-title="Utilisateurs et rôles">
                        <span class="menu-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="7" r="4"></circle><path d="M2 21v-2a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v2"></path></svg></span>
                        <span class="menu-title">Utilisateurs et rôles</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.backup.index') }}" class="{{ request()->routeIs('admin.backup.*') ? 'active' : '' }}" data-title="Sauvegarde">
                        <span class="menu-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="5" rx="8" ry="3"></ellipse><path d="M4 5v6c0 1.7 3.6 3 8 3s8-1.3 8-3V5"></path><path d="M4 11v6c0 1.7 3.6 3 8 3s8-1.3 8-3v-6"></path></svg></span>
                        <span class="menu-title">Sauvegarde</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('members.archived') }}" class="{{ request()->routeIs('members.archived') ? 'active' : '' }}" data-title="Membres archivés">
                        <span class="menu-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect></svg></span>
                        <span class="menu-title">Membres archivés</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('members.import.form') }}" class="{{ request()->routeIs('members.import.*') || request()->routeIs('members.export.*') ? 'active' : '' }}" data-title="Import / export CSV">
                        <span class="menu-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg></span>
                        <span class="menu-title">Import / export CSV</span>
                    </a>
                </li>
            </ul>
            @endif
            @endauth

            @auth
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        <span class="status-indicator-dot online" title="En ligne"></span>
                    </div>
                    <div class="user-details">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <span class="user-role-badge">
                            {{ Auth::user()->isAdmin() ? 'Administrateur' : (Auth::user()->isManager() ? 'Gestionnaire' : 'Consultation') }}
                        </span>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-logout" title="Se déconnecter de l'application">
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

    <script>
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const icons = {
            success: '<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>',
            error: '<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>',
            warning: '<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>',
            info: '<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>'
        };

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            ${icons[type] || icons.info}
            <span class="toast-message">${message}</span>
            <button class="toast-close" onclick="this.parentElement.remove()" aria-label="Fermer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        `;

        container.appendChild(toast);

        setTimeout(() => {
            if (toast.parentElement) {
                toast.classList.add('toast-removing');
                setTimeout(() => toast.remove(), 300);
            }
        }, 5000);
    }

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ session('success') }}', 'success');
        });
    @endif

    @if(session('error'))
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ session('error') }}', 'error');
        });
    @endif

    @if(session('warning'))
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ session('warning') }}', 'warning');
        });
    @endif

    @if(session('info'))
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ session('info') }}', 'info');
        });
    @endif

    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const sidebarCollapseBtn = document.getElementById('sidebarCollapseBtn');
    const sidebarSearchInput = document.getElementById('sidebarSearchInput');

    // Restaurer l'état réduit du sidebar sur grand écran
    if (window.innerWidth > 1024 && localStorage.getItem('eejc_sidebar_collapsed') === 'true') {
        document.body.classList.add('sidebar-collapsed');
    }

    // Toggle réduction desktop
    sidebarCollapseBtn?.addEventListener('click', function() {
        const isCollapsed = document.body.classList.toggle('sidebar-collapsed');
        localStorage.setItem('eejc_sidebar_collapsed', isCollapsed ? 'true' : 'false');
    });

    // Filtre dynamique des éléments du sidebar
    sidebarSearchInput?.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        const menuItems = document.querySelectorAll('.sidebar-menu li');
        
        menuItems.forEach(function(item) {
            const link = item.querySelector('a');
            const title = (link?.getAttribute('data-title') || link?.innerText || '').toLowerCase();
            if (!query || title.includes(query)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });

        // Masquer les titres de sections vides si recherche active
        document.querySelectorAll('.sidebar-section-title').forEach(function(sectionTitle) {
            let nextUl = sectionTitle.nextElementSibling;
            while (nextUl && !nextUl.classList.contains('sidebar-menu')) {
                nextUl = nextUl.nextElementSibling;
            }
            if (nextUl) {
                const visibleCount = nextUl.querySelectorAll('li:not([style*="display: none"])').length;
                sectionTitle.style.display = (query && visibleCount === 0) ? 'none' : '';
            }
        });
    });

    // Raccourci Echap pour effacer la recherche
    sidebarSearchInput?.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            this.value = '';
            this.dispatchEvent(new Event('input'));
            this.blur();
        }
    });

    function setSidebarOpen(open) {
        document.body.classList.toggle('sidebar-open', open);
        mobileMenuToggle?.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    mobileMenuToggle?.addEventListener('click', function() {
        setSidebarOpen(!document.body.classList.contains('sidebar-open'));
    });

    sidebarOverlay?.addEventListener('click', function() {
        setSidebarOpen(false);
    });

    document.querySelectorAll('.sidebar-menu a').forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) setSidebarOpen(false);
        });
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) setSidebarOpen(false);
    });
    </script>

    @stack('scripts')
</body>
</html>
