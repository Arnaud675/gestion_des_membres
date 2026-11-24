@forelse($members as $member)
    <tr class="member-row" data-member-id="{{ $member->id }}">
        <td data-label="Numéro de membre"><strong>N° {{ $member->numero_membre }}</strong></td>
        <td data-label="Photo" class="text-center">
            @if($member->photo)
                <div class="photo-container">
                    <img src="{{ asset('storage/' . $member->photo) }}" alt="Photo de {{ $member->nom }}" class="member-img">
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
        <td data-label="Nom complet"><div class="member-name">{{ $member->nom }} {{ $member->prenoms }}</div></td>
        <td data-label="Date naissance">
            <div class="date-badge">{{ \Carbon\Carbon::parse($member->date_naissance)->format('d/m/Y') }}</div>
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
                <a href="{{ route('members.show', $member->id) }}" class="btn-view" title="Voir">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M22 12c-2.667 4.667-6 7-10 7s-7.333-2.333-10-7c2.667-4.667 6-7 10-7s7.333 2.333 10 7z"></path>
                    </svg>
                </a>
                @if(auth()->user()->canManageMembers())
                    <a href="{{ route('members.edit', $member->id) }}" class="btn-edit" title="Modifier">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                            <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                        </svg>
                    </a>
                    <form action="{{ route('members.archive', $member) }}" method="POST" class="archive-form">
                        @csrf
                        <button type="submit" class="btn-delete" title="Archiver">
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
                <p>Modifiez les critères de recherche</p>
            </div>
        </td>
    </tr>
@endforelse