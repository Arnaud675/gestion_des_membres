@extends('layouts.app')

@section('title', 'Import-export CSV')

@section('content')
<div class="csv-container">
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="8" y1="13" x2="16" y2="13"></line>
                    <line x1="8" y1="17" x2="16" y2="17"></line>
                </svg>
                Import & Export des membres
            </h1>
            <p class="page-subtitle">Échangez et sauvegardez l'annuaire des fidèles au format CSV (séparateur virgule ou point-virgule).</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('members.index') }}" class="btn btn-outline">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Retour aux membres
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

    @if(session('import_ignored'))
        <div class="alert alert-warning">
            <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            <span>{{ session('import_ignored') }} ligne(s) ignorée(s) : numéro de membre déjà utilisé ou données invalides.</span>
        </div>
    @endif

    @if(session('import_errors'))
        <div class="alert alert-danger">
            @foreach(session('import_errors') as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="csv-grid">
        <!-- Carte d'import -->
        <div class="csv-card">
            <h2>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18" style="color: var(--blue);">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="17 8 12 3 7 8"></polyline>
                    <line x1="12" y1="3" x2="12" y2="15"></line>
                </svg>
                Importer un fichier CSV
            </h2>
            <p>Chargez un fichier CSV pour enregistrer des membres en lot. L'encodage recommandé est UTF-8.</p>

            @if(auth()->user()->canManageMembers())
                <form action="{{ route('members.import.csv') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="csv_file" class="upload-dropzone" id="dropzoneLabel" style="display: block;">
                        <input type="file" name="csv_file" id="csv_file" accept=".csv,text/csv,text/plain" required onchange="handleCsvFile(this)">
                        <div class="upload-dropzone-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="12" y1="18" x2="12" y2="12"></line>
                                <line x1="9" y1="15" x2="15" y2="15"></line>
                            </svg>
                        </div>
                        <div class="upload-dropzone-text" id="dropzoneFileName">Cliquez pour sélectionner un fichier CSV</div>
                        <div class="upload-dropzone-hint">Format .csv uniquement (max 10 Mo)</div>
                    </label>

                    <button type="submit" class="btn btn-primary" style="width: 100%; height: 42px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                        Lancer l'importation
                    </button>
                </form>
            @else
                <div class="alert alert-warning" style="margin-top: auto;">
                    Votre compte a des droits en consultation seule. L'import est réservé aux gestionnaires.
                </div>
            @endif
        </div>

        <!-- Carte d'export -->
        <div class="csv-card">
            <h2>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18" style="color: var(--green);">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                Exporter l'annuaire actif
            </h2>
            <p>Générez un extrait complet au format CSV standard UTF-8 contenant tous les membres actuellement enregistrés.</p>
            
            <div style="background-color: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 16px; margin-bottom: 20px;">
                <div style="font-size: 13px; font-weight: 600; color: var(--text-main); margin-bottom: 6px;">Données incluses dans l'export :</div>
                <div style="font-size: 12px; color: var(--text-muted); line-height: 1.6;">
                    Numéro de membre, identité complète, date et lieu de naissance, filiation parentale, profession, nationalité, situation matrimoniale et adresse postale.
                </div>
            </div>

            <div style="margin-top: auto;">
                <a href="{{ route('members.export.csv') }}" class="btn btn-primary" style="width: 100%; height: 42px; justify-content: center; background-color: var(--green); border-color: var(--green);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    Télécharger le fichier CSV
                </a>
            </div>
        </div>
    </div>

    <!-- Guide de structure du fichier CSV -->
    <div class="table-card" style="margin-top: 24px;">
        <div class="table-header">
            <h3>Structure requise pour le fichier d'importation</h3>
            <span class="badge badge-blue">Norme CSV EEJ-C</span>
        </div>

        <div class="table-responsive">
            <table class="csv-guide-table">
                <thead>
                    <tr>
                        <th>Nom de la colonne</th>
                        <th>Type attendu</th>
                        <th>Statut</th>
                        <th>Description / Exemple</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>numero_membre</code></td>
                        <td>Texte / Numérique</td>
                        <td><span class="badge badge-blue">Obligatoire</span></td>
                        <td>Identifiant unique du fidèle (ex : <code>M001</code>)</td>
                    </tr>
                    <tr>
                        <td><code>nom</code></td>
                        <td>Texte</td>
                        <td><span class="badge badge-blue">Obligatoire</span></td>
                        <td>Nom de famille (ex : <code>KOUASSI</code>)</td>
                    </tr>
                    <tr>
                        <td><code>prenoms</code></td>
                        <td>Texte</td>
                        <td><span class="badge badge-blue">Obligatoire</span></td>
                        <td>Prénoms (ex : <code>Aya Grace</code>)</td>
                    </tr>
                    <tr>
                        <td><code>date_naissance</code></td>
                        <td>Date (AAAA-MM-JJ)</td>
                        <td><span class="badge badge-blue">Obligatoire</span></td>
                        <td>Format standard (ex : <code>1990-05-14</code>)</td>
                    </tr>
                    <tr>
                        <td><code>lieu_naissance</code></td>
                        <td>Texte</td>
                        <td><span class="badge badge-blue">Obligatoire</span></td>
                        <td>Ville ou commune de naissance (ex : <code>Abidjan</code>)</td>
                    </tr>
                    <tr>
                        <td><code>nom_pere</code></td>
                        <td>Texte</td>
                        <td><span class="badge badge-yellow">Facultatif</span></td>
                        <td>Nom complet du père</td>
                    </tr>
                    <tr>
                        <td><code>nom_mere</code></td>
                        <td>Texte</td>
                        <td><span class="badge badge-yellow">Facultatif</span></td>
                        <td>Nom complet de la mère</td>
                    </tr>
                    <tr>
                        <td><code>profession</code></td>
                        <td>Texte</td>
                        <td><span class="badge badge-yellow">Facultatif</span></td>
                        <td>Profession ou activité principale</td>
                    </tr>
                    <tr>
                        <td><code>nationalite</code></td>
                        <td>Texte</td>
                        <td><span class="badge badge-yellow">Facultatif</span></td>
                        <td>Nationalité (ex : <code>Ivoirienne</code>)</td>
                    </tr>
                    <tr>
                        <td><code>situation_matrimoniale</code></td>
                        <td>Texte</td>
                        <td><span class="badge badge-yellow">Facultatif</span></td>
                        <td>Célibataire, Marié(e), Veuf(ve), Divorcé(e)</td>
                    </tr>
                    <tr>
                        <td><code>adresse</code></td>
                        <td>Texte</td>
                        <td><span class="badge badge-yellow">Facultatif</span></td>
                        <td>Lieu de résidence ou quartier</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
function handleCsvFile(input) {
    const label = document.getElementById('dropzoneFileName');
    if (input.files && input.files[0]) {
        label.innerText = 'Fichier sélectionné : ' + input.files[0].name;
        label.style.color = 'var(--blue)';
    }
}
</script>
@endpush
@endsection
