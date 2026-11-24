@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="users-container">
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                Utilisateurs et rôles
            </h1>
            <p class="page-subtitle">Administration des accès, attributions des droits et sécurité des comptes.</p>
        </div>
        <div class="header-actions">
            <span class="badge badge-blue" style="padding: 6px 14px; font-size: 13px;">{{ $users->total() }} comptes actifs</span>
        </div>
    </div>

    <!-- Statistiques rapides des comptes -->
    <div class="stats-grid" style="grid-template-columns: repeat(4, 1fr); margin-bottom: 24px;">
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--blue-soft); color: var(--blue);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total comptes</h3>
                <p class="stat-number">{{ $users->total() }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: var(--blue-soft); color: var(--blue);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Administrateurs</h3>
                <p class="stat-number">{{ \App\Models\User::where('role', 'admin')->count() }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: var(--green-soft); color: var(--green);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <polyline points="17 11 19 13 23 9"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Gestionnaires</h3>
                <p class="stat-number">{{ \App\Models\User::where('role', 'manager')->count() }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: var(--yellow-soft); color: var(--yellow-dark);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Consultation</h3>
                <p class="stat-number">{{ \App\Models\User::where('role', 'reader')->count() }}</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Tableau des utilisateurs existants -->
    <div class="table-card users-card">
        <div class="table-header">
            <h3>Liste des utilisateurs</h3>
            <span class="badge badge-blue">Page {{ $users->currentPage() }} sur {{ $users->lastPage() }}</span>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Adresse email</th>
                        <th>Rôle actuel</th>
                        <th>Modifier le rôle</th>
                        <th>Réinitialiser le mot de passe</th>
                        <th>Compte</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div class="user-avatar" style="width: 32px; height: 32px; font-size: 12px;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong style="color: var(--text-main); font-size: 14px;">{{ $user->name }}</strong>
                                        @if($user->id === auth()->id())
                                            <span class="badge badge-blue" style="font-size: 10px; margin-left: 4px;">Vous</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->isAdmin())
                                    <span class="badge badge-blue">Administrateur</span>
                                @elseif($user->isManager())
                                    <span class="badge badge-green">Gestionnaire</span>
                                @else
                                    <span class="badge badge-yellow">Consultation</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.users.role.update', $user) }}" method="POST" class="role-form">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" class="form-select" aria-label="Rôle de {{ $user->name }}">
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrateur</option>
                                        <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Gestionnaire</option>
                                        <option value="reader" {{ $user->role === 'reader' ? 'selected' : '' }}>Consultation</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm">Appliquer</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('admin.users.password.reset', $user) }}" method="POST" class="password-form">
                                    @csrf
                                    @method('PUT')
                                    <input type="password" name="password" placeholder="Nouveau mot de passe" minlength="6" required class="form-control">
                                    <input type="password" name="password_confirmation" placeholder="Confirmer" minlength="6" required class="form-control">
                                    <button type="submit" class="btn btn-outline btn-sm">Modifier</button>
                                </form>
                            </td>
                            <td>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-form" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce compte ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px;">
                                                <path d="M3 6h18M9 6v12m6-12v12"></path>
                                            </svg>
                                            Supprimer
                                        </button>
                                    </form>
                                @else
                                    <span class="badge badge-blue">Compte connecté</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-row">Aucun utilisateur trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-pagination">{{ $users->links() }}</div>
    </div>

    <!-- Carte de création d'un utilisateur -->
    <div class="users-create-card">
        <div class="card-header-styled">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20" style="color: var(--blue);">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <line x1="20" y1="8" x2="20" y2="14"></line>
                <line x1="23" y1="11" x2="17" y2="11"></line>
            </svg>
            <h2>Créer un nouvel utilisateur</h2>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="create-user-form-grid">
                <div class="form-group">
                    <label for="create_name" class="form-label">Nom complet *</label>
                    <input type="text" id="create_name" name="name" value="{{ old('name') }}" placeholder="Ex: Jean Dupont" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="create_email" class="form-label">Adresse email *</label>
                    <input type="email" id="create_email" name="email" value="{{ old('email') }}" placeholder="jean@eejc.org" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="create_role" class="form-label">Rôle attribué *</label>
                    <select id="create_role" name="role" required class="form-select">
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrateur</option>
                        <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>Gestionnaire</option>
                        <option value="reader" {{ old('role') === 'reader' ? 'selected' : '' }}>Consultation</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="create_password" class="form-label">Mot de passe *</label>
                    <input type="password" id="create_password" name="password" placeholder="6 caractères minimum" minlength="6" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="create_password_conf" class="form-label">Confirmation *</label>
                    <input type="password" id="create_password_conf" name="password_confirmation" placeholder="Répéter le mot de passe" minlength="6" required class="form-control">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; height: 42px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Créer le compte
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
