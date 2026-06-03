@extends('layouts.app')

@section('content')
<div class="welcome-container">
    <!-- Éléments décoratifs -->
    <div class="decoration-circle decoration-1"></div>
    <div class="decoration-circle decoration-2"></div>
    <div class="decoration-circle decoration-3"></div>
    
    <div class="welcome-card">
        <!-- Logo ou icône d'église -->
        <div class="church-icon">
            <img src="{{ asset('assets/LogoEEJC.jpeg') }}" alt="Logo EEJC" class="church-icon">
        </div>

        <!-- Titre principal -->
        <h1 class="welcome-title">
            <!-- <span class="title-line">Bienvenue sur le site de gestion</span> -->
            <span class="title-highlight">Eglise des Envoyés de Jésus-Christ</span>
        </h1>

        <!-- Séparateur décoratif -->
        <div class="separator">
            <span class="separator-line" style="background: var(--blue);"></span>
            <span class="separator-dot" style="background: var(--green);"></span>
            <span class="separator-line" style="background: var(--yellow);"></span>
        </div>

        <!-- Message de bienvenue -->
        <div class="welcome-message">
            @auth
                <div class="status-badge success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <span>Session active</span>
                </div>
                
                <p class="welcome-text">
                    Bonjour <strong>{{ Auth::user()->name ?? 'utilisateur' }}</strong>, vous êtes connecté.
                    Accédez à votre tableau de bord pour gérer les membres et les cotisations.
                </p>

                <div class="quick-stats">
                    <div class="stat-item">
                        <span class="stat-value">{{ \App\Models\Member::count() }}</span>
                        <span class="stat-label">Membres</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">{{ \App\Models\Member::where('created_at', '>=', now()->subDays(30))->count() }}</span>
                        <span class="stat-label">Nouveaux</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">{{ \App\Models\Cotisation::count() }}</span>
                        <span class="stat-label">Cotisations</span>
                    </div>
                </div>
            @else
                <div class="status-badge info">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                    Tableau de bord
                </a>

                <form method="POST" action="{{ route('logout') }}" class="logout-form">
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
                    Se connecter
                </a>

                {{-- <a href="{{ route('register') }}" class="btn-outline">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                    Créer un compte
                </a> --}}
            @endauth
        </div>

        <!-- Pied de page avec les couleurs de l'église -->
        <div class="footer-colors">
            <span style="background: var(--blue);"></span>
            <span style="background: var(--green);"></span>
            <span style="background: var(--yellow);"></span>
            <span style="background: var(--red);"></span>
        </div>
    </div>
</div>

<style>
/* ===== VARIABLES - COULEURS DU LOGO ===== */
:root {
    --blue: #1f4fd8;
    --green: #1fa85b;
    --yellow: #f2c200;
    --red: #d62828;
    --black: #111111;
    --bg-light: #f7f9fc;
    --border-soft: #e4e7ec;
    
    /* Ombres et dégradés */
    --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    
    /* Dégradés avec les couleurs du logo */
    --gradient-primary: linear-gradient(135deg, var(--blue) 0%, #4361ee 100%);
    --gradient-success: linear-gradient(135deg, var(--green) 0%, #2dc973 100%);
}

/* ===== CONTAINER PRINCIPAL ===== */
.welcome-container {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #f5f7fa 0%, #e9edf5 100%);
    position: relative;
    overflow: hidden;
    padding: 1rem;
}

/* ===== ÉLÉMENTS DÉCORATIFS ===== */
.decoration-circle {
    position: absolute;
    border-radius: 50%;
    filter: blur(60px);
    z-index: 0;
    animation: float 20s infinite ease-in-out;
}

.decoration-1 {
    width: 300px;
    height: 300px;
    background: rgba(31, 79, 216, 0.1);
    top: -100px;
    left: -100px;
    animation-delay: 0s;
}

.decoration-2 {
    width: 400px;
    height: 400px;
    background: rgba(31, 168, 91, 0.1);
    bottom: -150px;
    right: -150px;
    animation-delay: 5s;
}

.decoration-3 {
    width: 200px;
    height: 200px;
    background: rgba(242, 194, 0, 0.1);
    bottom: 20%;
    left: 10%;
    animation-delay: 10s;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0) rotate(0deg);
    }
    50% {
        transform: translateY(-20px) rotate(5deg);
    }
}

/* ===== CARTE PRINCIPALE ===== */
.welcome-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    max-width: 600px;
    width: 100%;
    padding: 3rem 2.5rem;
    border-radius: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.5);
    text-align: center;
    position: relative;
    z-index: 10;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    animation: slideUp 0.6s ease-out;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== ICÔNE D'ÉGLISE ===== */
.church-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 2rem;
    color: var(--blue);
    animation: gentlePulse 3s infinite;
}

@keyframes gentlePulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

.church-icon svg {
    width: 100%;
    height: 100%;
    stroke: var(--blue);
    fill: none;
}

/* ===== TITRE ===== */
.welcome-title {
    font-size: 1.8rem;
    color: var(--black);
    margin-bottom: 1.5rem;
    line-height: 1.4;
}

.title-line {
    display: block;
    font-weight: 400;
    font-size: 1.2rem;
    color: var(--gray-600);
    margin-bottom: 0.5rem;
}

.title-highlight {
    display: block;
    color: var(--blue);
    font-weight: 700;
    font-size: 1.8rem;
    background: linear-gradient(135deg, var(--blue) 0%, var(--green) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-transform: uppercase;
}

/* ===== SÉPARATEUR ===== */
.separator {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin: 2rem 0;
}

.separator-line {
    width: 50px;
    height: 3px;
    border-radius: 3px;
}

.separator-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

/* ===== MESSAGE DE BIENVENUE ===== */
.welcome-message {
    margin-bottom: 2rem;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 1rem;
}

.status-badge.success {
    background: rgba(31, 168, 91, 0.1);
    color: var(--green);
    border: 1px solid var(--green);
}

.status-badge.info {
    background: rgba(31, 79, 216, 0.1);
    color: var(--blue);
    border: 1px solid var(--blue);
}

.status-badge svg {
    width: 1rem;
    height: 1rem;
}

.welcome-text {
    color: #4a5568;
    font-size: 1rem;
    line-height: 1.6;
    margin: 1rem 0;
}

.welcome-text strong {
    color: var(--green);
    font-weight: 600;
}

/* ===== STATISTIQUES RAPIDES ===== */
.quick-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-top: 1.5rem;
    padding: 1rem;
    background: rgba(31, 79, 216, 0.05);
    border-radius: 1rem;
}

.stat-item {
    text-align: center;
}

.stat-value {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--blue);
    line-height: 1.2;
}

.stat-label {
    display: block;
    font-size: 0.75rem;
    color: #718096;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* ===== BOUTONS D'ACTION ===== */
.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin: 2rem 0 1.5rem;
    flex-wrap: wrap;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.75rem;
    background: var(--green);
    color: white;
    border: none;
    border-radius: 1rem;
    font-size: 1rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(31, 168, 91, 0.25);
    cursor: pointer;
}

.btn-primary:hover {
    background: #0f8a4a;
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(31, 168, 91, 0.3);
}

.btn-primary svg {
    width: 1.25rem;
    height: 1.25rem;
}

.btn-outline {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.75rem;
    background: transparent;
    color: var(--blue);
    border: 2px solid var(--blue);
    border-radius: 1rem;
    font-size: 1rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-outline:hover {
    background: var(--blue);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(31, 79, 216, 0.3);
}

.btn-outline svg {
    width: 1.25rem;
    height: 1.25rem;
}

.logout-form {
    display: inline;
}

/* ===== PIED DE PAGE COULEURS ===== */
.footer-colors {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
}

.footer-colors span {
    width: 30px;
    height: 4px;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.footer-colors span:hover {
    transform: scaleX(1.2);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 640px) {
    .welcome-card {
        padding: 2rem 1.5rem;
    }

    .welcome-title {
        font-size: 1.5rem;
    }

    .title-highlight {
        font-size: 1.5rem;
    }

    .action-buttons {
        flex-direction: column;
    }

    .btn-primary,
    .btn-outline {
        width: 100%;
        justify-content: center;
    }

    .quick-stats {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .decoration-1,
    .decoration-2,
    .decoration-3 {
        opacity: 0.5;
    }
}

/* ===== ANIMATIONS SUPPLÉMENTAIRES ===== */
@media (prefers-reduced-motion: reduce) {
    .decoration-circle,
    .church-icon,
    .welcome-card {
        animation: none;
    }
}

/* ===== MODE SOMBRE ADAPTÉ ===== */
@media (prefers-color-scheme: dark) {
    .welcome-container {
        background: linear-gradient(135deg, #1a1e2c 0%, #2a3042 100%);
    }

    .welcome-card {
        background: rgba(30, 34, 48, 0.95);
        border-color: rgba(255, 255, 255, 0.1);
    }

    .welcome-title {
        color: #e2e8f0;
    }

    .title-line {
        color: #a0aec0;
    }

    .welcome-text {
        color: #cbd5e0;
    }

    .stat-label {
        color: #a0aec0;
    }

    .footer-colors span {
        opacity: 0.8;
    }
}

/* ===== EFFET DE SURBRILLANCE ===== */
.welcome-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 50%;
    height: 100%;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255, 255, 255, 0.2),
        transparent
    );
    transition: left 0.5s ease;
}

.welcome-card:hover::before {
    left: 150%;
}
</style>

<script>
// Animation supplémentaire pour les statistiques (optionnel)
document.addEventListener('DOMContentLoaded', function() {
    const statValues = document.querySelectorAll('.stat-value');
    
    // Animation simple des nombres (si présents)
    statValues.forEach(stat => {
        const value = stat.textContent;
        if (!isNaN(parseInt(value))) {
            let current = 0;
            const target = parseInt(value);
            const increment = target / 30;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    stat.textContent = target;
                    clearInterval(timer);
                } else {
                    stat.textContent = Math.round(current);
                }
            }, 30);
        }
    });
});
</script>
@endsection