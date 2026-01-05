<div style="display:flex; justify-content:center; padding-top:100px;">
<form action="{{ route('login') }}" method="POST" class="login-form">
    @csrf

    <h2 class="login-title">Connexion</h2>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <small class="error">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label>Mot de passe</label>
        <input type="password" name="password" required>
        @error('password')
            <small class="error">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn-login">Se connecter</button>
</form>
</div>

<style>

     body {
    background: linear-gradient(135deg, #1e5aa8, #2e8b57);
    font-family: "Poppins", sans-serif;
}

    /* ===== FORMULAIRE LOGIN ===== */
.login-form {
    background: #ffffff;
    padding: 35px;
    width: 360px;
    border-radius: 16px;
    box-shadow: 0 20px 45px rgba(0,0,0,0.25);
    border-top: 6px solid #f4c430;
}

.login-title {
    text-align: center;
    margin-bottom: 25px;
    color: #1e5aa8;
    font-size: 24px;
    font-weight: 600;
}

.mb-3 {
    margin-bottom: 18px;
}

.login-form label {
    display: block;
    margin-bottom: 6px;
    color: #1c1c1c;
    font-weight: 500;
}

.login-form input {
    width: 100%;
    padding: 10px 12px;
    border-radius: 8px;
    border: 2px solid #1e5aa8;
    outline: none;
    transition: 0.3s;
    font-size: 14px;
}

.login-form input:focus {
    border-color: #2e8b57;
    box-shadow: 0 0 6px rgba(46,139,87,0.4);
}

.btn-login {
    width: 100%;
    margin-top: 10px;
    padding: 12px;
    background: linear-gradient(135deg, #f4c430, #1e5aa8);
    color: #ffffff;
    border: none;
    border-radius: 30px;
    font-weight: bold;
    font-size: 15px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-login:hover {
    background: linear-gradient(135deg, #1e5aa8, #2e8b57);
    transform: translateY(-2px);
}

/* ===== ERREURS ===== */
.error {
    color: #e74c3c;
    font-size: 13px;
}

</style>
