<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Affiche le formulaire de connexion
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Traitement de la connexion
     */
    public function login(Request $request)
    {
        // Validation
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Tentative de connexion
        if (Auth::attempt($credentials)) {
            // Regénérer la session pour sécurité
            $request->session()->regenerate();

            // Redirection vers la page souhaitée ou dashboard
            return redirect()->intended(route('admin.dashboard'));
        }

        // Retour avec message d'erreur si échec
        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->withInput(); // garde l’email saisi
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalider la session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirection vers page d'accueil
        return redirect()->route('welcome');
    }
}
