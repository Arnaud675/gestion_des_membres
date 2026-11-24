@extends('layouts.app')

@section('title', 'Membres archivés')

@section('content')
<div class="archived-container">
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="21 8 21 21 3 21 3 8"></polyline>
                    <rect x="1" y="3" width="22" height="5"></rect>
                    <line x1="10" y1="12" x2="14" y2="12"></line>
                </svg>
                Membres archivés
            </h1>
            <p class="page-subtitle">Ces membres sont conservés dans les archives avec l'intégralité de leur historique financier.</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('members.index') }}" class="btn btn-outline">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Retour aux membres actifs
            </a>
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

    <form method="GET" action="{{ route('members.archived') }}" class="filters-bar">
        <div class="search-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="search" name="search" value="{{ $search }}" placeholder="Rechercher un membre archivé par nom, prénom ou numéro..." class="form-control">
        </div>
    </form>

    <div class="table-card archived-card">
        <div class="table-header">
            <h3>Archives de l'assemblée</h3>
            <span class="badge badge-yellow">{{ $members->total() }} membres archivés</span>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Numéro</th>
                        <th>Membre</th>
                        <th>Profession</th>
                        <th>Archivé le</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                        <tr>
                            <td><span class="badge badge-blue">N° {{ $member->numero_membre }}</span></td>
                            <td><strong style="color: var(--text-main); font-size: 14px;">{{ $member->nom }} {{ $member->prenoms }}</strong></td>
                            <td>{{ $member->profession ?: '—' }}</td>
                            <td>
                                <span class="date-badge">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                    {{ $member->archived_at?->format('d/m/Y à H:i') }}
                                </span>
                            </td>
                            <td style="text-align: right;">
                                @if(auth()->user()->canManageMembers())
                                    <form action="{{ route('members.restore', $member) }}" method="POST" style="margin: 0; display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                                <polyline points="1 4 1 10 7 10"></polyline>
                                                <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                                            </svg>
                                            Restaurer
                                        </button>
                                    </form>
                                @else
                                    <span style="color: var(--text-muted);">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-row" style="padding: 40px 20px; text-align: center; color: var(--text-muted);">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="40" height="40" style="margin-bottom: 8px; opacity: 0.5;">
                                    <polyline points="21 8 21 21 3 21 3 8"></polyline>
                                    <rect x="1" y="3" width="22" height="5"></rect>
                                    <line x1="10" y1="12" x2="14" y2="12"></line>
                                </svg>
                                <p style="font-weight: 600; color: var(--text-main);">Aucun membre dans les archives.</p>
                                <p style="font-size: 13px;">Tous les membres inscrits sont actuellement actifs.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-pagination">{{ $members->links() }}</div>
    </div>
</div>
@endsection
