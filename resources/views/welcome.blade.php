@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="welcome-container" style="min-height: auto; padding: 20px 0;">
    <div class="welcome-card" style="max-width: 620px;">
        <!-- Logo d'église -->
        <div class="church-icon text-center">
            <img src="{{ asset('assets/LogoEEJC.jpeg') }}" alt="Logo EEJC" style="width: 72px; height: 72px; border-radius: 16px; border: 2px solid var(--blue); margin-bottom: 16px;">
        </div>

        <!-- Titre principal -->
        <h1 class="welcome-title text-center">
            Église des Envoyés de Jésus-Christ
        </h1>

        <!-- Séparateur décoratif solide -->
        <div class="separator">
            <span class="separator-line" style="background: var(--blue);"></span>
            <span class="separator-dot" style="background: var(--green);"></span>
            <span class="separator-line" style="background: var(--yellow-dark);"></span>
        </div>

        <!-- Message de bienvenue -->
        <div class="welcome-message">
            @auth
                <div class="status-badge success" style="margin: 0 auto 12px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <span>Session active</span>
                </div>
                
                <p class="welcome-text">
                    Bonjour <strong>{{ Auth::user()->name ?? 'utilisateur' }}</strong>, vous êtes connecté.
                    Accédez à votre tableau de bord pour administrer les membres et les cotisations.
                </p>

                <div class="quick-stats" style="grid-template-columns: repeat(3, 1fr); gap: 12px; margin: 20px 0;">
                    <div class="stat-card" style="padding: 14px; flex-direction: column; text-align: center;">
                        <span class="stat-number" style="font-size: 20px;">{{ \App\Models\Member::count() }}</span>
                        <span style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Membres</span>
                    </div>
                    <div class="stat-card" style="padding: 14px; flex-direction: column; text-align: center;">
                        <span class="stat-number" style="font-size: 20px;">{{ \App\Models\Member::where('created_at', '>=', now()->subDays(30))->count() }}</span>
                        <span style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Nouveaux</span>
                    </div>
                    <div class="stat-card" style="padding: 14px; flex-direction: column; text-align: center;">
                        <span class="stat-number" style="font-size: 20px;">{{ \App\Models\Cotisation::count() }}</span>
                        <span style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Cotisations</span>
                    </div>
                </div>
            @else
                <div class="status-badge pending" style="margin: 0 auto 12px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="12" x2="12" y2="16"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <span>Accès restreint</span>
                </div>

                <p class="welcome-text">
                    Veuillez vous connecter pour accéder à l'espace de gestion 
                    des membres et des cotisations de l'église.
                </p>
            @endauth
        </div>

        <!-- Actions principales -->
        <div class="action-buttons">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    Accéder au tableau de bord
                </a>

                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-outline">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Déconnexion
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="4"></circle>
                        <path d="M5.8 15.2a8 8 0 0 1 12.4 0"></path>
                    </svg>
                    Se connecter à l'espace membre
                </a>
            @endauth
        </div>

        <!-- Pied de page avec les couleurs solides de l'église -->
        <div class="footer-colors">
            <span style="background: var(--blue);"></span>
            <span style="background: var(--green);"></span>
            <span style="background: var(--yellow);"></span>
            <span style="background: var(--red);"></span>
        </div>
    </div>
</div>
@endsection
