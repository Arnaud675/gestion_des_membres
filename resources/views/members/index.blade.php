@extends('layouts.app')

@section('title', 'Membres')

@section('content')
<div class="members-wrapper">
    <!-- En-tête -->
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                Liste des membres
            </h1>
            <p class="page-subtitle">Consultez et administrez le répertoire officiel des fidèles</p>
        </div>
        
        <div class="header-actions">
            <a href="{{ route('members.archived') }}" class="btn btn-outline">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="21 8 21 21 3 21 3 8"></polyline>
                    <rect x="1" y="3" width="22" height="5"></rect>
                    <line x1="10" y1="12" x2="14" y2="12"></line>
                </svg>
                Membres archivés
            </a>
            @if(auth()->user()->canManageMembers())
                <a href="{{ route('members.create') }}" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Ajouter un membre
                </a>
            @endif
            <a href="{{ route('members.import.form') }}" class="btn btn-blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
                Import / export CSV
            </a>
        </div>
    </div>

    <!-- Filtres -->
    <form action="{{ route('members.index') }}" method="GET" class="filters-section">
        <div class="search-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom, prénom ou numéro..." id="searchInput">
        </div>
        
        <div class="filter-wrapper">
            <select class="filter-select" name="filter" id="filterSelect" aria-label="Filtrer les membres">
                <option value="">Tous les membres</option>
                <option value="avec_photo" {{ request('filter') === 'avec_photo' ? 'selected' : '' }}>Avec photo</option>
                <option value="sans_photo" {{ request('filter') === 'sans_photo' ? 'selected' : '' }}>Sans photo</option>
                <option value="avec_profession" {{ request('filter') === 'avec_profession' ? 'selected' : '' }}>Avec profession</option>
            </select>
        </div>
    </form>

    <!-- Carte du tableau -->
    <div class="table-card members-card">
        <table class="members-table">
            <thead>
                <tr>
                    <th>Numéro de membre</th>
                    <th>Photo</th>
                    <th>Nom & Prénoms</th>
                    <th>Date de naissance</th>
                    <th>Profession</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody id="membersRows">
                @forelse($members as $member)
                    <tr class="member-row" data-member-id="{{ $member->id }}">
                        <td data-label="Numéro de membre"><strong>N° {{ $member->numero_membre }}</strong></td>

                        <td data-label="Photo" class="text-center">
                            @if($member->photo)
                                <div class="photo-container">
                                    <img src="{{ asset('storage/' . $member->photo) }}"
                                         alt="photo"
                                         class="member-img">
                                </div>
                            @else
                                <div class="photo-placeholder">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </div>
                            @endif
                        </td>

                        <td data-label="Nom complet">
                            <div class="member-name">
                                {{ $member->nom }} {{ $member->prenoms }}
                            </div>
                        </td>

                        <td data-label="Date naissance">
                            <div class="date-badge">
                                {{ \Carbon\Carbon::parse($member->date_naissance)->format('d/m/Y') }}
                            </div>
                        </td>

                        <td data-label="Profession">
                            @if($member->profession)
                                <span class="profession-badge">{{ $member->profession }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        <td data-label="Actions">
                            <div class="actions">
                                <a href="{{ route('members.show', $member->id) }}" class="btn-view" title="Consulter la fiche">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="3"></circle>
                                        <path d="M22 12c-2.667 4.667-6 7-10 7s-7.333-2.333-10-7c2.667-4.667 6-7 10-7s7.333 2.333 10 7z"></path>
                                    </svg>
                                </a>
                                
                                @if(auth()->user()->canManageMembers())
                                    <a href="{{ route('members.edit', $member->id) }}" class="btn-edit" title="Modifier le membre">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                                            <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                                        </svg>
                                    </a>

                                    <form action="{{ route('members.archive', $member->id) }}" method="POST" class="archive-form" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="btn-delete" onclick="return confirm('Archiver ce membre ? Son historique sera conservé.')" title="Archiver">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="21 8 21 21 3 21 3 8"></polyline>
                                                <rect x="1" y="3" width="22" height="5"></rect>
                                                <line x1="10" y1="12" x2="14" y2="12"></line>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <div class="empty-content">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <line x1="23" y1="1" x2="1" y2="23"></line>
                                </svg>
                                <h3>Aucun membre trouvé</h3>
                                <p>Commencez par ajouter votre premier membre</p>
                                @if(auth()->user()->canManageMembers())
                                    <a href="{{ route('members.create') }}" class="btn btn-primary" style="margin-top: 10px;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                        Ajouter un membre
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if(method_exists($members, 'links'))
            <div class="pagination-wrapper" id="membersPagination">
                {{ $members->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
const memberFiltersForm = document.querySelector('.filters-section');
const memberSearchInput = document.getElementById('searchInput');
const memberFilterSelect = document.getElementById('filterSelect');
const memberRows = document.getElementById('membersRows');
const memberPagination = document.getElementById('membersPagination');
let memberSearchTimeout;
let memberRequestController;

async function loadMembers(url, updateHistory = true) {
    memberRequestController?.abort();
    memberRequestController = new AbortController();
    memberFiltersForm?.setAttribute('aria-busy', 'true');

    try {
        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            signal: memberRequestController.signal,
        });

        if (!response.ok) {
            throw new Error('Impossible de charger les membres.');
        }

        const data = await response.json();
        memberRows.innerHTML = data.rows;
        if (memberPagination && data.pagination) {
            memberPagination.innerHTML = data.pagination;
        }

        if (updateHistory) {
            window.history.pushState({}, '', url);
        }
    } catch (error) {
        if (error.name !== 'AbortError') {
            window.location.assign(url);
        }
    } finally {
        memberFiltersForm?.removeAttribute('aria-busy');
    }
}

function loadFilteredMembers() {
    if (!memberFiltersForm) return;

    const url = new URL(memberFiltersForm.action, window.location.origin);
    const formData = new FormData(memberFiltersForm);
    formData.forEach((value, key) => {
        if (value) url.searchParams.set(key, value);
    });

    loadMembers(url.toString());
}

memberFiltersForm?.addEventListener('submit', function(event) {
    event.preventDefault();
    loadFilteredMembers();
});

memberSearchInput?.addEventListener('input', function() {
    clearTimeout(memberSearchTimeout);
    memberSearchTimeout = setTimeout(loadFilteredMembers, 350);
});

memberFilterSelect?.addEventListener('change', function() {
    loadFilteredMembers();
});

memberPagination?.addEventListener('click', function(event) {
    const link = event.target.closest('a');
    if (!link || !link.href) return;

    event.preventDefault();
    loadMembers(link.href);
});

window.addEventListener('popstate', function() {
    loadMembers(window.location.href, false);
});
</script>
@endpush
@endsection
