<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | EEJ-C</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/LogoEEJC.jpeg') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
</head>
<body>
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-content">
            <!-- Logo et titre -->
            <div class="auth-header">
                <div class="logo-wrapper">
                    <img src="{{ asset('assets/LogoEEJC.jpeg') }}" alt="Logo Église des Envoyés de Jésus-Christ" class="auth-logo">
                </div>
                
                <h1 class="auth-title">
                    Espace de Gestion
                </h1>
                
                <div class="auth-badge-group">
                    <span class="auth-badge" style="background: var(--blue);">Administration</span>
                    <span class="auth-badge" style="background: var(--green);">Membres</span>
                    <span class="auth-badge" style="background: var(--yellow-dark);">Cotisations</span>
                </div>
            </div>

            <!-- Formulaire de connexion -->
            <div class="auth-form-wrapper">
                <form action="{{ route('login') }}" method="POST" class="auth-form">
                    @csrf

                    <div class="form-header">
                        <h2 class="form-title">Connexion</h2>
                        <p class="form-subtitle">Accédez à votre espace sécurisé</p>
                    </div>

                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <svg class="form-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Adresse email
                        </label>
                        <div class="input-wrapper">
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                value="{{ old('email') }}" 
                                class="form-input @error('email') is-invalid @enderror" 
                                placeholder="votre@email.com" 
                                required 
                                autofocus
                            >
                        </div>
                        @error('email')
                            <div class="form-error">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <svg class="form-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            Mot de passe
                        </label>
                        <div class="input-wrapper">
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="form-input @error('password') is-invalid @enderror" 
                                placeholder="••••••••" 
                                required
                            >
                            <button type="button" class="password-toggle" onclick="togglePassword()" aria-label="Afficher le mot de passe">
                                <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="form-error">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Options de connexion -->
                    <div class="form-options">
                        <label class="checkbox-container">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span class="checkbox-label">Se souvenir de moi</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        <span>Se connecter</span>
                        <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16">
                            <path d="M13 5l7 7-7 7M5 12h15"/>
                        </svg>
                    </button>

                    <!-- Message de sécurité -->
                    <div class="security-note">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <span>Accès sécurisé • Connexion chiffrée</span>
                    </div>
                </form>
            </div>

            <!-- Footer avec couleurs solides de l'église -->
            <div class="auth-footer">
                <div class="footer-colors">
                    <span style="background: var(--blue);"></span>
                    <span style="background: var(--green);"></span>
                    <span style="background: var(--yellow);"></span>
                    <span style="background: var(--red);"></span>
                </div>
                <p class="copyright">
                    © {{ date('Y') }} Église des Envoyés de Jésus-Christ. Tous droits réservés.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
}
</script>
</body>
</html>
