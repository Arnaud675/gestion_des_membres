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
/* CONTENEUR CENTRÉ */
.login-form {
    width: 380px;
    background: #ffffff;
    padding: 35px;
    border-radius: 18px;
    border: 1px solid #e4e7ec;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

/* TITRE */
.login-title {
    text-align: center;
    margin-bottom: 25px;
    color: #1f4fd8; /* Bleu du logo */
    font-size: 22px;
}

/* CHAMPS */
.login-form .mb-3 {
    margin-bottom: 18px;
}

.login-form label {
    display: block;
    margin-bottom: 6px;
    font-size: 14px;
    color: #111111;
}

.login-form input {
    width: 100%;
    padding: 11px 14px;
    border-radius: 10px;
    border: 1px solid #dcdfe6;
    font-size: 14px;
    transition: 0.2s;
}

.login-form input:focus {
    outline: none;
    border-color: #1fa85b; /* Vert du logo */
}

/* ERREURS */
.error {
    color: #d62828; /* Rouge */
    font-size: 12px;
    margin-top: 4px;
    display: block;
}

/* BOUTON */
.btn-login {
    width: 100%;
    margin-top: 10px;
    padding: 12px;
    background: #1fa85b; /* Vert */
    color: #ffffff;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: 0.25s;
}

.btn-login:hover {
    background: #168f4c;
}

</style>
