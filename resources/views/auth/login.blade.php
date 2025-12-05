 
 
 <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email"  required>
        </div>

        <div class="mb-3">
            <label>Mot de passe</label>
            <input type="password" name="password" required>
        </div>

        <button >Se connecter</button>
    </form>