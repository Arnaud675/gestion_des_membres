@extends('layouts.app')

@section('title', 'Historique des actions')

@section('content')
<div class="audit-container">
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"></circle>
                    <polyline points="12 7 12 12 16 14"></polyline>
                </svg>
                Historique des actions
            </h1>
            <p class="page-subtitle">Journal d'audit et traçabilité des créations, modifications et suppressions du système.</p>
        </div>
        <div class="header-actions">
            <span class="badge badge-blue" style="padding: 6px 14px; font-size: 13px;">{{ $logs->total() }} événements audités</span>
        </div>
    </div>

    <form method="GET" action="{{ route('audit.index') }}" class="filters-bar audit-filters">
        <div class="search-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Description, membre ou IP..." class="form-control">
        </div>

        <div class="filter-group">
            <select name="action" class="form-select filter-select" aria-label="Filtrer par action">
                <option value="">Toutes les actions</option>
                <option value="created" {{ request('action') === 'created' ? 'selected' : '' }}>Créations</option>
                <option value="updated" {{ request('action') === 'updated' ? 'selected' : '' }}>Modifications</option>
                <option value="deleted" {{ request('action') === 'deleted' ? 'selected' : '' }}>Suppressions</option>
            </select>

            <select name="subject_type" class="form-select filter-select" aria-label="Filtrer par objet">
                <option value="">Tous les objets</option>
                <option value="App\Models\Member" {{ request('subject_type') === 'App\Models\Member' ? 'selected' : '' }}>Membres</option>
                <option value="App\Models\Cotisation" {{ request('subject_type') === 'App\Models\Cotisation' ? 'selected' : '' }}>Cotisations</option>
                <option value="App\Models\Depense" {{ request('subject_type') === 'App\Models\Depense' ? 'selected' : '' }}>Dépenses</option>
            </select>

            <select name="user_id" class="form-select filter-select" aria-label="Filtrer par utilisateur">
                <option value="">Tous les utilisateurs</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ (string) request('user_id') === (string) $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                </svg>
                Filtrer
            </button>
        </div>
    </form>

    <div class="table-card audit-table-card">
        <div class="table-header">
            <h3>Journal chronologique des modifications</h3>
            <span class="badge badge-blue">Page {{ $logs->currentPage() }} sur {{ $logs->lastPage() }}</span>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date & Heure</th>
                        <th>Utilisateur</th>
                        <th>Type d'action</th>
                        <th>Détails de l'opération</th>
                        <th>Objet concerné</th>
                        <th>Adresse IP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        @php
                            $actionLabels = ['created' => 'Création', 'updated' => 'Modification', 'deleted' => 'Suppression'];
                            $actionBadges = [
                                'created' => 'badge-green',
                                'updated' => 'badge-blue',
                                'deleted' => 'badge-red'
                            ];
                            $typeLabels = [
                                'App\Models\Member' => 'Membre',
                                'App\Models\Cotisation' => 'Cotisation',
                                'App\Models\Depense' => 'Dépense',
                            ];
                        @endphp
                        <tr>
                            <td>
                                <span class="date-badge">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                    {{ $log->created_at->format('d/m/Y à H:i') }}
                                </span>
                            </td>
                            <td>
                                <strong style="color: var(--text-main); font-size: 13.5px;">{{ $log->user?->name ?? 'Compte supprimé' }}</strong>
                            </td>
                            <td>
                                <span class="badge {{ $actionBadges[$log->action] ?? 'badge-blue' }}">
                                    {{ $actionLabels[$log->action] ?? $log->action }}
                                </span>
                            </td>
                            <td><span style="font-size: 13.5px; color: var(--text-body);">{{ $log->description }}</span></td>
                            <td>
                                <div>
                                    <strong style="color: var(--text-main); font-size: 13px;">{{ $typeLabels[$log->subject_type] ?? 'Objet' }}</strong>
                                    @if($log->subject_label)
                                        <br><span class="badge badge-blue" style="margin-top: 4px; font-size: 11px;">{{ $log->subject_label }}</span>
                                    @endif
                                </div>
                            </td>
                            <td><code style="background-color: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 12px; border: 1px solid var(--border-color); color: var(--text-muted);">{{ $log->ip_address ?: '—' }}</code></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-row" style="padding: 40px 20px; text-align: center; color: var(--text-muted);">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="40" height="40" style="margin-bottom: 8px; opacity: 0.5;">
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <polyline points="12 7 12 12 16 14"></polyline>
                                </svg>
                                <p style="font-weight: 600; color: var(--text-main);">Aucune action enregistrée</p>
                                <p style="font-size: 13px;">Aucun journal ne correspond à vos critères de recherche.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-pagination">{{ $logs->links() }}</div>
    </div>
</div>
@endsection
