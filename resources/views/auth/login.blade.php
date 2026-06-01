<div class="auth-container">
    <!-- Éléments décoratifs -->
    <div class="decoration-circle decoration-1"></div>
    <div class="decoration-circle decoration-2"></div>
    <div class="decoration-circle decoration-3"></div>
    
    <div class="auth-card">
        <!-- Bannière avec dégradé -->
        <!-- <div class="auth-banner">
            <div class="banner-overlay"></div>
        </div> -->
        
        <div class="auth-content">
            <!-- Logo et titre -->
            <div class="auth-header">
                <div class="logo-wrapper">
                    <img src="{{ asset('assets/LogoEEJC.jpeg') }}" alt="Logo Église des Envoyés de Jésus-Christ" class="auth-logo">
                    <div class="logo-glow"></div>
                </div>
                
                <h1 class="auth-title">
                    <!-- <span class="title-line">Bienvenue sur</span> -->
                    <span class="title-highlight">l'Espace de Gestion</span>
                </h1>
                
                <div class="auth-badge-group">
                    <span class="auth-badge" style="background: var(--blue);">Administrateur</span>
                    <span class="auth-badge" style="background: var(--green);">Membres</span>
                    <span class="auth-badge" style="background: var(--yellow);">Cotisations</span>
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
                            <svg class="form-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                            <span class="input-focus-border"></span>
                        </div>
                        @error('email')
                            <div class="form-error">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                            <svg class="form-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                            <span class="input-focus-border"></span>
                        </div>
                        @error('password')
                            <div class="form-error">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                            <span class="checkmark"></span>
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
                        <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M13 5l7 7-7 7M5 12h15"/>
                        </svg>
                        <div class="btn-glow"></div>
                    </button>

                    <!-- Message de sécurité -->
                    <div class="security-note">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <span>Accès sécurisé • Connexion cryptée</span>
                    </div>
                </form>
            </div>

            <!-- Footer avec couleurs de l'église -->
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

<style>
/* ===== VARIABLES ===== */
:root {
    --blue: #1f4fd8;
    --blue-dark: #183fb4;
    --blue-soft: #e8edff;
    
    --green: #1fa85b;
    --green-dark: #168f4c;
    --green-soft: #e8f5e9;
    
    --yellow: #f2c200;
    --yellow-dark: #d9ae00;
    --yellow-soft: #fff9e6;
    
    --red: #d62828;
    --red-dark: #b91f1f;
    --red-soft: #fee2e2;
    
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-800: #1f2937;
    --gray-900: #111827;
    
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    --shadow-green: 0 4px 14px 0 rgba(31, 168, 91, 0.3);
}

/* ===== CONTAINER PRINCIPAL ===== */
.auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #62dda0 0%, #57bd8d 100%);
    position: relative;
    overflow: hidden;
    padding: 1.5rem;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* ===== ÉLÉMENTS DÉCORATIFS ===== */
.decoration-circle {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    z-index: 0;
    animation: float 20s infinite ease-in-out;
}

.decoration-1 {
    width: 400px;
    height: 400px;
    background: rgba(31, 79, 216, 0.2);
    top: -150px;
    left: -150px;
    animation-delay: 0s;
}

.decoration-2 {
    width: 500px;
    height: 500px;
    background: rgba(31, 168, 91, 0.2);
    bottom: -200px;
    right: -200px;
    animation-delay: 5s;
}

.decoration-3 {
    width: 300px;
    height: 300px;
    background: rgba(242, 194, 0, 0.15);
    bottom: 20%;
    left: 20%;
    animation-delay: 10s;
}

@keyframes float {
    0%, 100% {
        transform: translate(0, 0) rotate(0deg);
    }
    33% {
        transform: translate(30px, -30px) rotate(5deg);
    }
    66% {
        transform: translate(-30px, 20px) rotate(-5deg);
    }
}

/* ===== CARTE PRINCIPALE ===== */
.auth-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    max-width: 1000px;
    width: 35%;
    border-radius: 2rem;
    overflow: hidden;
    box-shadow: var(--shadow-2xl);
    border: 1px solid rgba(255, 255, 255, 0.5);
    position: relative;
    z-index: 10;
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

/* ===== BANNIÈRE ===== */
.auth-banner {
    height: 120px;
    background: linear-gradient(135deg, var(--blue) 0%, var(--green) 50%, var(--yellow) 100%);
    position: relative;
}

.banner-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 100%);
}

/* ===== CONTENU ===== */
.auth-content {
    padding: 2.5rem 3rem;
    margin-top: -40px;
}

/* ===== HEADER AVEC LOGO ===== */
.auth-header {
    text-align: center;
    margin-bottom: 2rem;
}

.logo-wrapper {
    position: relative;
    display: inline-block;
    margin-bottom: 1rem;
}

.auth-logo {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: var(--shadow-xl);
    position: relative;
    z-index: 2;
    transition: transform 0.3s ease;
}

.auth-logo:hover {
    transform: scale(1.05);
}

.logo-glow {
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    background: radial-gradient(circle, rgba(31, 168, 91, 0.3) 0%, transparent 70%);
    border-radius: 50%;
    animation: pulse 2s infinite;
    z-index: 1;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        opacity: 0.5;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.8;
    }
}

.auth-title {
    margin: 0.5rem 0 1rem;
}

.title-line {
    display: block;
    font-size: 1rem;
    color: var(--gray-500);
    font-weight: 400;
    margin-bottom: 0.25rem;
}

.title-highlight {
    display: block;
    font-size: 1.8rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--blue) 0%, var(--green) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.auth-badge-group {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

.auth-badge {
    padding: 0.35rem 1rem;
    border-radius: 2rem;
    color: white;
    font-size: 0.7rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    opacity: 0.9;
}

/* ===== FORMULAIRE ===== */
.auth-form-wrapper {
    max-width: 400px;
    margin: 0 auto;
}

.form-header {
    text-align: center;
    margin-bottom: 2rem;
}

.form-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-800);
    margin: 0 0 0.25rem;
}

.form-subtitle {
    font-size: 0.875rem;
    color: var(--gray-500);
    margin: 0;
}

/* ===== FORM GROUP ===== */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-700);
    margin-bottom: 0.5rem;
}

.form-icon {
    width: 1.125rem;
    height: 1.125rem;
    color: var(--green);
}

/* ===== INPUT WRAPPER ===== */
.input-wrapper {
    position: relative;
}

.form-input {
    width: 100%;
    padding: 0.875rem 1rem;
    font-size: 0.95rem;
    color: var(--gray-800);
    background: var(--gray-50);
    border: 2px solid var(--gray-200);
    border-radius: 0.75rem;
    transition: all 0.3s ease;
    outline: none;
}

.form-input:focus {
    border-color: var(--green);
    background: white;
    box-shadow: 0 0 0 3px rgba(31, 168, 91, 0.1);
}

.form-input.is-invalid {
    border-color: var(--red);
    background: var(--red-soft);
}

.form-input.is-invalid:focus {
    box-shadow: 0 0 0 3px rgba(214, 40, 40, 0.1);
}

.input-focus-border {
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--green), var(--blue));
    transition: all 0.3s ease;
    transform: translateX(-50%);
}

.form-input:focus ~ .input-focus-border {
    width: 100%;
}

/* ===== PASSWORD TOGGLE ===== */
.password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.25rem;
    color: var(--gray-400);
    transition: color 0.2s ease;
}

.password-toggle:hover {
    color: var(--green);
}

.eye-icon {
    width: 1.25rem;
    height: 1.25rem;
}

/* ===== ERROR MESSAGE ===== */
.form-error {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    margin-top: 0.5rem;
    font-size: 0.75rem;
    color: var(--red);
    background: var(--red-soft);
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    border: 1px solid var(--red);
}

.form-error svg {
    width: 1rem;
    height: 1rem;
    flex-shrink: 0;
}

/* ===== FORM OPTIONS ===== */
.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 1.5rem 0;
}

.checkbox-container {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    font-size: 0.875rem;
    color: var(--gray-600);
    user-select: none;
}

.checkbox-container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

.checkmark {
    position: relative;
    height: 1.125rem;
    width: 1.125rem;
    background: var(--gray-50);
    border: 2px solid var(--gray-300);
    border-radius: 0.25rem;
    transition: all 0.2s ease;
}

.checkbox-container:hover input ~ .checkmark {
    background: var(--gray-100);
    border-color: var(--gray-400);
}

.checkbox-container input:checked ~ .checkmark {
    background: var(--green);
    border-color: var(--green);
}

.checkmark:after {
    content: "";
    position: absolute;
    display: none;
    left: 0.3rem;
    top: 0.1rem;
    width: 0.25rem;
    height: 0.5rem;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.checkbox-container input:checked ~ .checkmark:after {
    display: block;
}

.checkbox-label {
    color: var(--gray-600);
}

.forgot-link {
    font-size: 0.875rem;
    color: var(--blue);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s ease;
}

.forgot-link:hover {
    color: var(--green);
    text-decoration: underline;
}

/* ===== SUBMIT BUTTON ===== */
.btn-submit {
    position: relative;
    width: 100%;
    padding: 0.875rem 1.5rem;
    background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%);
    color: white;
    border: none;
    border-radius: 0.75rem;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    overflow: hidden;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-green);
}

.btn-submit:active {
    transform: translateY(0);
}

.btn-icon {
    width: 1.25rem;
    height: 1.25rem;
    transition: transform 0.3s ease;
}

.btn-submit:hover .btn-icon {
    transform: translateX(4px);
}

.btn-glow {
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.btn-submit:hover .btn-glow {
    opacity: 1;
}

/* ===== SECURITY NOTE ===== */
.security-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1.5rem;
    padding: 0.75rem;
    background: var(--gray-50);
    border-radius: 0.75rem;
    font-size: 0.75rem;
    color: var(--gray-500);
    border: 1px solid var(--gray-200);
}

.security-note svg {
    width: 1rem;
    height: 1rem;
    color: var(--green);
}

/* ===== FOOTER ===== */
.auth-footer {
    margin-top: 2rem;
    text-align: center;
}

.footer-colors {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.footer-colors span {
    width: 40px;
    height: 4px;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.footer-colors span:hover {
    transform: scaleX(1.2);
}

.copyright {
    font-size: 0.7rem;
    color: var(--gray-400);
    margin: 0;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 1024px) {
    .auth-card {
        width: 50%;
    }
}

@media (max-width: 768px) {
    .auth-container {
        padding: 1rem;
    }

    .auth-card {
        width: 90%;
        max-width: 500px;
    }

    .auth-content {
        padding: 1.5rem;
        margin-top: -20px;
    }

    .auth-logo {
        width: 70px;
        height: 70px;
    }

    .auth-title .title-highlight {
        font-size: 1.3rem;
    }

    .auth-badge {
        padding: 0.25rem 0.75rem;
        font-size: 0.65rem;
    }

    .auth-form-wrapper {
        max-width: 100%;
    }

    .form-title {
        font-size: 1.3rem;
    }

    .form-subtitle {
        font-size: 0.8rem;
    }

    .form-group {
        margin-bottom: 1.2rem;
    }

    .form-label {
        font-size: 0.8rem;
    }

    .form-input {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }

    .form-options {
        flex-direction: column;
        gap: 0.8rem;
        align-items: flex-start;
        margin: 1rem 0;
    }

    .checkbox-label {
        font-size: 0.8rem;
    }

    .forgot-link {
        font-size: 0.8rem;
        align-self: flex-start;
    }

    .btn-submit {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }

    .btn-icon {
        width: 1rem;
        height: 1rem;
    }

    .security-note {
        padding: 0.6rem;
        font-size: 0.7rem;
        gap: 0.3rem;
    }

    .security-note svg {
        width: 0.9rem;
        height: 0.9rem;
    }

    .auth-footer {
        margin-top: 1.5rem;
    }

    .footer-colors {
        gap: 0.4rem;
        margin-bottom: 0.8rem;
    }

    .footer-colors span {
        width: 30px;
        height: 3px;
    }

    .copyright {
        font-size: 0.65rem;
    }

    .decoration-1,
    .decoration-2,
    .decoration-3 {
        opacity: 0.3;
    }
}

@media (max-width: 480px) {
    .auth-container {
        padding: 0.8rem;
    }

    .auth-card {
        width: 100%;
        max-width: 100%;
        border-radius: 1.5rem;
    }

    .auth-content {
        padding: 1.2rem;
        margin-top: -15px;
    }

    .logo-wrapper {
        margin-bottom: 0.5rem;
    }

    .auth-logo {
        width: 60px;
        height: 60px;
        border-width: 3px;
    }

    .auth-title {
        margin: 0.3rem 0 0.5rem;
    }

    .auth-title .title-highlight {
        font-size: 1.1rem;
    }

    .auth-badge-group {
        gap: 0.3rem;
    }

    .auth-badge {
        padding: 0.2rem 0.6rem;
        font-size: 0.6rem;
    }

    .form-header {
        margin-bottom: 1.2rem;
    }

    .form-title {
        font-size: 1.1rem;
    }

    .form-subtitle {
        font-size: 0.7rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-label {
        font-size: 0.75rem;
        margin-bottom: 0.3rem;
    }

    .form-icon {
        width: 0.9rem;
        height: 0.9rem;
    }

    .form-input {
        padding: 0.65rem 0.8rem;
        font-size: 0.85rem;
    }

    .password-toggle {
        right: 0.7rem;
    }

    .eye-icon {
        width: 1rem;
        height: 1rem;
    }

    .form-error {
        padding: 0.4rem 0.6rem;
        font-size: 0.7rem;
        gap: 0.25rem;
    }

    .form-error svg {
        width: 0.8rem;
        height: 0.8rem;
    }

    .form-options {
        gap: 0.6rem;
        margin: 0.8rem 0;
    }

    .checkbox-container {
        gap: 0.3rem;
    }

    .checkmark {
        width: 0.9rem;
        height: 0.9rem;
    }

    .checkmark:after {
        left: 0.22rem;
        top: 0.06rem;
        width: 0.2rem;
        height: 0.4rem;
    }

    .checkbox-label {
        font-size: 0.75rem;
    }

    .forgot-link {
        font-size: 0.75rem;
    }

    .btn-submit {
        padding: 0.65rem 0.8rem;
        font-size: 0.85rem;
        gap: 0.3rem;
    }

    .btn-icon {
        width: 0.9rem;
        height: 0.9rem;
    }

    .security-note {
        padding: 0.5rem;
        font-size: 0.65rem;
        margin-top: 1rem;
    }

    .security-note svg {
        width: 0.8rem;
        height: 0.8rem;
    }

    .auth-footer {
        margin-top: 1rem;
    }

    .footer-colors {
        gap: 0.3rem;
        margin-bottom: 0.5rem;
    }

    .footer-colors span {
        width: 25px;
        height: 3px;
    }

    .copyright {
        font-size: 0.6rem;
    }

    .decoration-1,
    .decoration-2,
    .decoration-3 {
        display: none;
    }
}

/* Pour les très petits écrans (moins de 360px) */
@media (max-width: 360px) {
    .auth-content {
        padding: 1rem;
    }

    .auth-logo {
        width: 50px;
        height: 50px;
    }

    .auth-title .title-highlight {
        font-size: 1rem;
    }

    .form-title {
        font-size: 1rem;
    }

    .form-input {
        padding: 0.6rem 0.7rem;
        font-size: 0.8rem;
    }

    .btn-submit {
        padding: 0.6rem 0.7rem;
        font-size: 0.8rem;
    }
}

/* Pour les tablettes en mode portrait (entre 768px et 1024px) */
@media (min-width: 769px) and (max-width: 1024px) {
    .auth-card {
        width: 60%;
        max-width: 600px;
    }

    .auth-content {
        padding: 2rem;
    }

    .auth-logo {
        width: 85px;
        height: 85px;
    }

    .auth-title .title-highlight {
        font-size: 1.5rem;
    }

    .form-title {
        font-size: 1.4rem;
    }
}

/* Pour les grands écrans (amélioration) */
@media (min-width: 1400px) {
    .auth-card {
        max-width: 1100px;
    }

    .auth-content {
        padding: 3rem 4rem;
    }

    .auth-logo {
        width: 120px;
        height: 120px;
    }

    .auth-title .title-highlight {
        font-size: 2.2rem;
    }

    .auth-form-wrapper {
        max-width: 450px;
    }
}

/* Mode paysage sur mobile */
@media (max-width: 768px) and (orientation: landscape) {
    .auth-container {
        min-height: auto;
        padding: 1rem;
    }

    .auth-card {
        width: 80%;
        max-width: 600px;
    }

    .auth-content {
        padding: 1rem 1.5rem;
    }

    .auth-logo {
        width: 55px;
        height: 55px;
    }

    .auth-title .title-highlight {
        font-size: 1.2rem;
    }

    .auth-badge-group {
        margin-bottom: 0.5rem;
    }

    .form-header {
        margin-bottom: 1rem;
    }

    .form-group {
        margin-bottom: 0.8rem;
    }

    .auth-footer {
        margin-top: 1rem;
    }
}

/* Amélioration de la hauteur sur mobile */
@media (max-width: 480px) and (max-height: 700px) {
    .auth-container {
        min-height: auto;
        padding: 0.8rem;
    }

    .auth-content {
        padding: 1rem;
    }

    .auth-logo {
        width: 50px;
        height: 50px;
    }

    .auth-title .title-highlight {
        font-size: 1rem;
    }

    .auth-badge-group {
        gap: 0.2rem;
        margin-bottom: 0.3rem;
    }

    .form-header {
        margin-bottom: 0.8rem;
    }

    .form-group {
        margin-bottom: 0.7rem;
    }

    .form-options {
        margin: 0.6rem 0;
    }

    .security-note {
        margin-top: 0.7rem;
    }

    .auth-footer {
        margin-top: 0.7rem;
    }
}

/* ===== MODE SOMBRE ADAPTÉ ===== */
@media (prefers-color-scheme: dark) {
    .auth-card {
        background: rgba(30, 34, 48, 0.95);
        border-color: rgba(255, 255, 255, 0.1);
    }

    .form-title {
        color: var(--gray-100);
    }

    .form-input {
        background: var(--gray-800);
        border-color: var(--gray-700);
        color: var(--gray-100);
    }

    .form-input:focus {
        background: var(--gray-700);
    }

    .checkbox-label {
        color: var(--gray-300);
    }

    .security-note {
        background: var(--gray-800);
        border-color: var(--gray-700);
        color: var(--gray-400);
    }

    .copyright {
        color: var(--gray-500);
    }
}

/* ===== ANIMATIONS DE CHARGEMENT ===== */
@keyframes shimmer {
    0% {
        background-position: -1000px 0;
    }
    100% {
        background-position: 1000px 0;
    }
}

.form-input:invalid {
    animation: none;
}
</style>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    
    // Animation du bouton
    const button = document.querySelector('.password-toggle');
    button.style.transform = 'translateY(-50%) scale(0.95)';
    setTimeout(() => {
        button.style.transform = 'translateY(-50%) scale(1)';
    }, 150);
}

// Animation des champs au focus
document.querySelectorAll('.form-input').forEach(input => {
    input.addEventListener('focus', () => {
        input.parentElement.classList.add('focused');
    });
    
    input.addEventListener('blur', () => {
        input.parentElement.classList.remove('focused');
    });
});

// Validation en temps réel (optionnel)
document.getElementById('email').addEventListener('input', function(e) {
    const email = e.target.value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (email && !emailRegex.test(email)) {
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
    }
});
</script>
