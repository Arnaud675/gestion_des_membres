<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Http\Requests\MembersCheckRequest;
use App\Models\Member;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index()
    {
        $query = Member::active();
        $search = request('search');
        $filter = request('filter');

        if ($search) {
            $query->where(function ($memberQuery) use ($search) {
                $memberQuery->where('nom', 'like', '%' . $search . '%')
                    ->orWhere('prenoms', 'like', '%' . $search . '%')
                    ->orWhere('numero_membre', 'like', '%' . $search . '%')
                    ->orWhere('profession', 'like', '%' . $search . '%');
            });
        }

        if ($filter === 'avec_photo') {
            $query->whereNotNull('photo')->where('photo', '!=', '');
        } elseif ($filter === 'sans_photo') {
            $query->where(function ($memberQuery) {
                $memberQuery->whereNull('photo')->orWhere('photo', '');
            });
        } elseif ($filter === 'avec_profession') {
            $query->whereNotNull('profession')->where('profession', '!=', '');
        }

        $members = $query->orderBy('nom')->orderBy('prenoms')->paginate(15)->withQueryString();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'rows' => view('members.partials.rows', compact('members'))->render(),
                'pagination' => view('members.partials.pagination', compact('members'))->render(),
            ]);
        }

        return view('members.index', compact('members'));
    }

    public function create()
    {
        /** @var User $user */
        $user = Auth::user();
        if (! $user->canManageMembers()) {
            return redirect()->route('members.index')->with('error', 'Vous n’avez pas la permission d’ajouter des membres.');
        }
        return view('members.create');
    }

    public function store(MembersCheckRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();
        if (! $user->canManageMembers()) {
            return redirect()->route('members.index')->with('error', 'Vous n’avez pas la permission d’ajouter des membres.');
        }

        $data = $request->except('photo');

        
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('members', 'public');
        }

        $member = Member::create($data);

        AuditLogger::log(
            'created',
            $member,
            'Création du membre ' . $member->nom . ' ' . $member->prenoms,
            'N° ' . $member->numero_membre
        );

        return redirect()->route('members.index')
            ->with('success', 'Membre ajouté avec succès !');
    }

    public function show($id)
    {
        $member = Member::findOrFail($id);
        return view('members.show', compact('member'));
    }


    public function edit($id)
    {
        /** @var User $user */
        $user = Auth::user();
        if (! $user->canManageMembers()) {
            return redirect()->route('members.index')->with('error', 'Vous n’avez pas la permission de modifier les membres.');
        }
        $member = Member::findOrFail($id);
        return view('members.edit', compact('member'));
    }

    public function update(MembersCheckRequest $request, $id)
    {
        /** @var User $user */
        $user = Auth::user();
        if (! $user->canManageMembers()) {
            return redirect()->route('members.index')->with('error', 'Vous n’avez pas la permission de modifier les membres.');
        }

        $member = Member::findOrFail($id);
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }
        $member->update($data);

        AuditLogger::log(
            'updated',
            $member,
            'Modification du membre ' . $member->nom . ' ' . $member->prenoms,
            'N° ' . $member->numero_membre
        );

        return redirect()->route('members.show', $member->id)->with('success', 'Membre mis à jour.');
    }

    public function destroy($id)
    {
        /** @var User $user */
        $user = Auth::user();
        if (! $user->canManageMembers()) {
            return redirect()->route('members.index')->with('error', 'Vous n’avez pas la permission de supprimer les membres.');
        }

        $member = Member::findOrFail($id);

        if ($member->cotisations()->exists()) {
            return redirect()->route('members.index')->with(
                'error',
                'Ce membre ne peut pas être supprimé car il possède un historique de cotisations.'
            );
        }

        // Supprimer la photo si elle existe
        if ($member->photo && Storage::disk('public')->exists($member->photo)) {
            Storage::disk('public')->delete($member->photo);
        }

        $memberLabel = 'N° ' . $member->numero_membre;
        $memberDescription = 'Suppression du membre ' . $member->nom . ' ' . $member->prenoms;

        $member->delete();

        AuditLogger::log(
            'deleted',
            $member,
            $memberDescription,
            $memberLabel
        );

        return redirect()->route('members.index')
            ->with('success', 'Membre supprimé avec succès !');
    }

    public function archive($id)
    {
        /** @var User $user */
        $user = Auth::user();
        if (! $user->canManageMembers()) {
            return redirect()->route('members.index')->with('error', 'Vous n’avez pas la permission d’archiver des membres.');
        }

        $member = Member::active()->findOrFail($id);
        $member->archive();

        AuditLogger::log(
            'updated',
            $member,
            'Archivage du membre ' . $member->nom . ' ' . $member->prenoms,
            'N° ' . $member->numero_membre
        );

        return redirect()->route('members.index')
            ->with('success', 'Membre archivé avec succès.');
    }

    public function restore($id)
    {
        /** @var User $user */
        $user = Auth::user();
        if (! $user->canManageMembers()) {
            return redirect()->route('members.archived')->with('error', 'Vous n’avez pas la permission de restaurer des membres.');
        }

        $member = Member::archived()->findOrFail($id);
        $member->restore();

        AuditLogger::log(
            'updated',
            $member,
            'Restauration du membre ' . $member->nom . ' ' . $member->prenoms,
            'N° ' . $member->numero_membre
        );

        return redirect()->route('members.archived')
            ->with('success', 'Membre restauré avec succès.');
    }

    public function archived()
    {
        $search = trim((string) request('search'));

        $query = Member::archived();
        if ($search !== '') {
            $query->where(function ($members) use ($search) {
                $members->where('nom', 'like', '%' . $search . '%')
                    ->orWhere('prenoms', 'like', '%' . $search . '%')
                    ->orWhere('numero_membre', 'like', '%' . $search . '%');
            });
        }

        $members = $query->orderByDesc('archived_at')->paginate(15)->withQueryString();

        return view('members.archived', compact('members', 'search'));
    }

    public function exportCsv()
    {
        /** @var User $user */
        $user = Auth::user();
        if (! $user->canManageMembers() && ! $user->isReader()) {
            return redirect()->route('members.index')->with('error', 'Vous n’avez pas l’autorisation d’exporter les membres.');
        }

        $filename = 'membres_actifs_' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () {
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($output, [
                'numero_membre', 'nom', 'prenoms', 'date_naissance', 'lieu_naissance',
                'nom_pere', 'nom_mere', 'profession', 'nationalite',
                'situation_matrimoniale', 'adresse',
            ], ';');

            Member::active()->orderBy('nom')->orderBy('prenoms')->each(function (Member $member) use ($output) {
                fputcsv($output, [
                    $member->numero_membre,
                    $member->nom,
                    $member->prenoms,
                    (string) $member->date_naissance,
                    $member->lieu_naissance,
                    $member->nom_pere,
                    $member->nom_mere,
                    $member->profession,
                    $member->nationalite,
                    $member->situation_matrimoniale,
                    $member->adresse,
                ], ';');
            });

            fclose($output);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function importForm()
    {
        /** @var User $user */
        $user = Auth::user();
        if (! $user->canManageMembers()) {
            return redirect()->route('members.index')->with('error', 'Vous n’avez pas la permission d’importer des membres.');
        }

        return view('members.import');
    }

    public function importCsv(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        if (! $user->canManageMembers()) {
            return redirect()->route('members.index')->with('error', 'Vous n’avez pas la permission d’importer des membres.');
        }

        $validated = $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $handle = fopen($validated['csv_file']->getRealPath(), 'r');
        if (! $handle) {
            return back()->withErrors(['csv_file' => 'Impossible de lire le fichier CSV.']);
        }

        $firstLine = fgets($handle);
        rewind($handle);
        $delimiter = str_contains((string) $firstLine, ';') ? ';' : ',';

        $headers = fgetcsv($handle, null, $delimiter);
        if (! $headers) {
            fclose($handle);
            return back()->withErrors(['csv_file' => 'Le fichier CSV est vide ou illisible.']);
        }

        $headers = array_map(function ($header) {
            $header = preg_replace('/^\xEF\xBB\xBF/', '', (string) $header);
            return strtolower(trim($header));
        }, $headers);

        $requiredHeaders = ['numero_membre', 'nom', 'prenoms', 'date_naissance', 'lieu_naissance'];
        $missingHeaders = array_values(array_diff($requiredHeaders, $headers));
        if ($missingHeaders) {
            fclose($handle);
            return back()->withErrors([
                'csv_file' => 'Colonnes obligatoires manquantes : ' . implode(', ', $missingHeaders),
            ]);
        }

        $created = 0;
        $ignored = 0;
        $errors = [];
        $line = 1;

        while (($row = fgetcsv($handle, null, $delimiter)) !== false) {
            $line++;
            if (count($row) === 1 && trim((string) $row[0]) === '') {
                continue;
            }

            $data = array_combine($headers, array_pad($row, count($headers), null));
            if (! is_array($data)) {
                $ignored++;
                continue;
            }

            $numero = trim((string) ($data['numero_membre'] ?? ''));
            $nom = trim((string) ($data['nom'] ?? ''));
            $prenoms = trim((string) ($data['prenoms'] ?? ''));
            $dateNaissance = trim((string) ($data['date_naissance'] ?? ''));
            $lieuNaissance = trim((string) ($data['lieu_naissance'] ?? ''));

            if ($numero === '' || $nom === '' || $prenoms === '' || $dateNaissance === '' || $lieuNaissance === '') {
                $errors[] = 'Ligne ' . $line . ' : champs obligatoires manquants.';
                $ignored++;
                continue;
            }

            if (! strtotime($dateNaissance)) {
                $errors[] = 'Ligne ' . $line . ' : date de naissance invalide.';
                $ignored++;
                continue;
            }

            if (Member::where('numero_membre', $numero)->exists()) {
                $ignored++;
                continue;
            }

            Member::create([
                'numero_membre' => $numero,
                'nom' => $nom,
                'prenoms' => $prenoms,
                'date_naissance' => date('Y-m-d', strtotime($dateNaissance)),
                'lieu_naissance' => $lieuNaissance,
                'nom_pere' => trim((string) ($data['nom_pere'] ?? '')) ?: null,
                'nom_mere' => trim((string) ($data['nom_mere'] ?? '')) ?: null,
                'profession' => trim((string) ($data['profession'] ?? '')) ?: null,
                'nationalite' => trim((string) ($data['nationalite'] ?? '')) ?: null,
                'situation_matrimoniale' => trim((string) ($data['situation_matrimoniale'] ?? '')) ?: null,
                'adresse' => trim((string) ($data['adresse'] ?? '')) ?: null,
            ]);

            $created++;
        }

        fclose($handle);

        return redirect()->route('members.import.form')->with([
            'success' => $created . ' membre(s) importé(s).',
            'import_ignored' => $ignored,
            'import_errors' => array_slice($errors, 0, 20),
        ]);
    }
}
