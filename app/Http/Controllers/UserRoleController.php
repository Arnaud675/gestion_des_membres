<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AuditLogger;

class UserRoleController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->canManageUsers(), 403);

        $users = User::orderBy('name')->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function update(Request $request, User $user)
    {
        abort_unless(auth()->user()->canManageUsers(), 403);

        $validated = $request->validate([
            'role' => 'required|in:admin,manager,reader',
        ]);

        if ($user->is(auth()->user()) && $validated['role'] !== 'admin') {
            return back()->withErrors([
                'role' => 'Vous ne pouvez pas retirer votre propre rôle administrateur.',
            ]);
        }

        $user->update(['role' => $validated['role']]);

        return back()->with('success', 'Rôle de l’utilisateur mis à jour.');
    }

    public function resetPassword(Request $request, User $user)
    {
        abort_unless(auth()->user()->canManageUsers(), 403);

        $validated = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required' => 'Le nouveau mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        $user->update(['password' => $validated['password']]);

        return back()->with('success', 'Mot de passe réinitialisé pour ' . $user->name . '.');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->canManageUsers(), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'role' => 'required|in:admin,manager,reader',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => $validated['password'],
        ]);

        return back()->with('success', 'Compte utilisateur créé avec succès.');
    }

    public function destroy(User $user)
    {
        abort_unless(auth()->user()->canManageUsers(), 403);

        if ($user->is(auth()->user())) {
            return back()->withErrors([
                'delete' => 'Vous ne pouvez pas supprimer votre propre compte.',
            ]);
        }

        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return back()->withErrors([
                'delete' => 'Impossible de supprimer le dernier administrateur.',
            ]);
        }

        if ($user->depenses()->exists()) {
            return back()->withErrors([
                'delete' => 'Ce compte ne peut pas être supprimé car il possède des dépenses enregistrées. Changez son rôle ou conservez son historique.',
            ]);
        }

        $label = $user->name . ' (' . $user->email . ')';
        $role = $user->role;

        $user->delete();

        AuditLogger::log(
            'deleted',
            null,
            'Suppression du compte ' . $label . ' — ancien rôle : ' . $role,
            $label
        );

        return back()->with('success', 'Compte utilisateur supprimé avec succès.');
    }
}
