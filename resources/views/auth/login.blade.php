<div class="auth-container">
    <div class="auth-content">
        <!-- Logo Section -->
        <div class="auth-logo-section">
            <img src="{{ asset('assets/LogoEEJC.jpeg') }}" alt="Logo EEJC" class="auth-logo">
            <div class="auth-badge">Gestion des Membres</div>
        </div>

        <!-- Form Section -->
        <div class="auth-form-section">
            <form action="{{ route('login') }}" method="POST" class="login-form">
                @csrf

                <div class="form-header">
                    <h1 class="form-title">Bienvenue</h1>
                    <p class="form-subtitle">Connectez-vous à votre compte</p>
                </div>

                <!-- Email Field -->
                <div class="form-group">
                    <label for="email" class="form-label">
                        <svg class="form-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Email
                    </label>
                    <input 
                        id="email"
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        class="form-input"
                        placeholder="votre@email.com"
                        required
                    >
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password" class="form-label">
                        <svg class="form-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M12 1a5 5 0 00-5 5v6a5 5 0 0010 0V6a5 5 0 00-5-5zm0 0v6m0 0H6m6 0h6"/>
                        </svg>
                        Mot de passe
                    </label>
                    <input 
                        id="password"
                        type="password" 
                        name="password" 
                        class="form-input"
                        placeholder="••••••••"
                        required
                    >
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">
                    <span>Se connecter</span>
                    <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M13 5l7 7-7 7M5 12h15"/>
                    </svg>
                </button>

                <!-- Footer -->
                <div class="form-footer">
                    <p class="footer-text">Accès réservé aux administrateurs</p>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Main Container */
.auth-container {
    min-height: 91vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #8bd3ab 0%, #8bd3ab 100%);
    padding: 20px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
}

.auth-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
    max-width: 1000px;
    width: 100%;
}

/* Logo Section */
.auth-logo-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 30px;
}

.auth-logo {
    width: 200px;
    height: auto;
    object-fit: contain;
    filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.08));
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
}

.auth-badge {
    padding: 12px 28px;
    background: #1fa85b;
    color: white;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* Form Section */
.auth-form-section {
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding-right: 100px;
}

.login-form {
    background: #ffffff;
    padding: 50px;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(31, 168, 91, 0.1);
}

/* Form Header */
.form-header {
    margin-bottom: 40px;
    text-align: left;
}

.form-title {
    font-size: 28px;
    font-weight: 700;
    color: #1a202c;
    margin: 0 0 8px 0;
    letter-spacing: -0.5px;
    text-align: center;
}

.form-subtitle {
    font-size: 14px;
    color: #718096;
    margin: 0;
    font-weight: 500;
    text-align: center;
}

/* Form Groups */
.form-group {
    margin-bottom: 22px;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 8px;
    cursor: pointer;
}

.form-icon {
    width: 18px;
    height: 18px;
    stroke-width: 2;
    color: #1fa85b;
    flex-shrink: 0;
}

.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 500;
    background: #f8fafc;
    color: #1a202c;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

.form-input:focus {
    outline: none;
    border-color: #1fa85b;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(31, 168, 91, 0.1);
}

.form-input::placeholder {
    color: #a0aec0;
}

/* Form Error */
.form-error {
    display: block;
    margin-top: 6px;
    font-size: 12px;
    color: #e53e3e;
    font-weight: 500;
}

/* Submit Button */
.btn-submit {
    width: 100%;
    padding: 13px 20px;
    margin-top: 25px;
    background: linear-gradient(135deg, #1fa85b 0%, #168f4c 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-submit:hover {
    background: linear-gradient(135deg, #168f4c 0%, #0f7a3f 100%);
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(31, 168, 91, 0.3);
}

.btn-submit:active {
    transform: translateY(0);
}

.btn-icon {
    width: 18px;
    height: 18px;
    stroke-width: 2.5;
    flex-shrink: 0;
}

/* Form Footer */
.form-footer {
    margin-top: 25px;
    text-align: center;
}

.footer-text {
    font-size: 12px;
    color: #a0aec0;
    margin: 0;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .auth-content {
        grid-template-columns: 1fr;
        gap: 40px;
    }

    .auth-logo {
        width: 150px;
    }

    .login-form {
        padding: 35px;
    }

    .form-title {
        font-size: 24px;
    }

    .form-header {
        margin-bottom: 30px;
    }
}

@media (max-width: 480px) {
    .auth-container {
        padding: 15px;
    }

    .auth-content {
        gap: 30px;
    }

    .login-form {
        padding: 25px;
    }

    .form-title {
        font-size: 20px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .btn-submit {
        padding: 11px 16px;
        font-size: 14px;
    }
}
</style>
