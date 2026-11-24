@extends('layouts.app')

@section('title', 'Sauvegarde de la base')

@section('content')
<div class="backup-container">
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <ellipse cx="12" cy="5" rx="8" ry="3"></ellipse>
                    <path d="M4 5v6c0 1.7 3.6 3 8 3s8-1.3 8-3V5"></path>
                    <path d="M4 11v6c0 1.7 3.6 3 8 3s8-1.3 8-3v-6"></path>
                </svg>
                Sauvegarde et restauration
            </h1>
            <p class="page-subtitle">Administration et maintenance de la base de données PostgreSQL.</p>
        </div>
        <div class="header-actions">
            <span class="badge badge-blue" style="padding: 6px 14px; font-size: 13px;">Connexion : {{ strtoupper($connection) }}</span>
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

    @if($connection !== 'pgsql')
        <div class="alert alert-warning">
            <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            <span>Cette page prend en charge PostgreSQL. La connexion actuelle configurée est de type <strong>{{ $connection }}</strong>.</span>
        </div>
    @else
        <!-- Indicateurs de sauvegarde -->
        <div class="stats-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 24px;">
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--blue-soft); color: var(--blue);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <ellipse cx="12" cy="5" rx="8" ry="3"></ellipse>
                        <path d="M4 5v6c0 1.7 3.6 3 8 3s8-1.3 8-3V5"></path>
                        <path d="M4 11v6c0 1.7 3.6 3 8 3s8-1.3 8-3v-6"></path>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>Fichiers disponibles</h3>
                    <p class="stat-number">{{ $backups->count() }}</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: var(--green-soft); color: var(--green);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>Espace total occupé</h3>
                    <p class="stat-number">{{ number_format($backups->sum('size') / 1024, 1, ',', ' ') }} Ko</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: var(--yellow-soft); color: var(--yellow-dark);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect>
                        <rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect>
                        <line x1="6" y1="6" x2="6.01" y2="6"></line>
                        <line x1="6" y1="18" x2="6.01" y2="18"></line>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>Moteur de données</h3>
                    <p class="stat-number" style="font-size: 18px;">PostgreSQL</p>
                </div>
            </div>
        </div>

        <div class="backup-grid">
            <!-- Créer une sauvegarde -->
            <div class="backup-card">
                <h2>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18" style="color: var(--blue);">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    </svg>
                    Créer une sauvegarde
                </h2>
                <p>Génère un instantané SQL complet de toutes les tables, séquences et données actuelles de l'application.</p>
                <form action="{{ route('admin.backup.create') }}" method="POST" style="margin-top: auto;">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width: 100%; height: 42px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Générer la sauvegarde maintenant
                    </button>
                </form>
            </div>

            <!-- Restaurer une sauvegarde -->
            <div class="backup-card danger-card">
                <h2>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18" style="color: var(--red);">
                        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    Restaurer une sauvegarde
                </h2>
                <p><strong>Zone critique</strong> : cette opération remplace irréversiblement les tables actuelles par l'archive choisie.</p>
                <form action="{{ route('admin.backup.restore') }}" method="POST" onsubmit="return confirm('Attention : toutes les données actuelles seront remplacées. Êtes-vous certain de vouloir continuer ?')">
                    @csrf
                    <div class="form-group" style="margin-bottom: 12px;">
                        <label for="backup" class="form-label">Sélectionner l'archive *</label>
                        <select name="backup" id="backup" required class="form-select">
                            <option value="">Sélectionnez un fichier</option>
                            @foreach($backups as $backup)
                                <option value="{{ $backup['name'] }}">{{ $backup['name'] }} — {{ number_format($backup['size'] / 1024, 1, ',', ' ') }} Ko</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label for="confirmation" class="form-label">Tapez RESTAURER en majuscules pour déverrouiller *</label>
                        <input type="text" id="confirmation" name="confirmation" placeholder="RESTAURER" required class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-danger" style="width: 100%; height: 42px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                            <polyline points="1 4 1 10 7 10"></polyline>
                            <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                        </svg>
                        Restaurer cette version
                    </button>
                </form>
            </div>
        </div>

        <!-- Tableau des sauvegardes stockées -->
        <div class="table-card backup-list-card">
            <div class="table-header">
                <h3>Historique des sauvegardes</h3>
                <span class="badge badge-blue">{{ $backups->count() }} sauvegardes enregistrées</span>
            </div>
            @if($backups->isEmpty())
                <div class="empty-row" style="padding: 40px 20px; text-align: center; color: var(--text-muted);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="40" height="40" style="margin-bottom: 8px; opacity: 0.5;">
                        <ellipse cx="12" cy="5" rx="8" ry="3"></ellipse>
                        <path d="M4 5v6c0 1.7 3.6 3 8 3s8-1.3 8-3V5"></path>
                        <path d="M4 11v6c0 1.7 3.6 3 8 3s8-1.3 8-3v-6"></path>
                    </svg>
                    <p>Aucun fichier de sauvegarde disponible sur le serveur.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nom de l'archive</th>
                                <th>Date de création</th>
                                <th>Taille du fichier</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($backups as $backup)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16" style="color: var(--blue);">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                            </svg>
                                            <strong style="color: var(--text-main);">{{ $backup['name'] }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $backup['created_at'] }}</td>
                                    <td><span class="badge badge-blue">{{ number_format($backup['size'] / 1024, 1, ',', ' ') }} Ko</span></td>
                                    <td style="text-align: right;">
                                        <a href="{{ route('admin.backup.download', $backup['name']) }}" class="btn btn-outline btn-sm">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="7 10 12 15 17 10"></polyline>
                                                <line x1="12" y1="15" x2="12" y2="3"></line>
                                            </svg>
                                            Télécharger
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
