<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class DatabaseBackupController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->canManageUsers(), 403);

        $connection = config('database.default');
        $backups = collect(glob(storage_path('app/private/backups/*.sql')) ?: [])
            ->sortDesc()
            ->map(fn (string $path) => [
                'name' => basename($path),
                'size' => filesize($path),
                'created_at' => date('d/m/Y à H:i', filemtime($path)),
            ]);

        return view('admin.backups', compact('connection', 'backups'));
    }

    public function createBackup()
    {
        abort_unless(auth()->user()->canManageUsers(), 403);

        if (config('database.default') !== 'pgsql') {
            return back()->withErrors(['backup' => 'La sauvegarde automatique est actuellement disponible uniquement avec PostgreSQL.']);
        }

        $pgDump = $this->postgresExecutable('pg_dump.exe');
        if (! $pgDump) {
            return back()->withErrors(['backup' => 'PostgreSQL pg_dump est introuvable sur cet ordinateur.']);
        }

        $directory = storage_path('app/private/backups');
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = 'sauvegarde_' . now()->format('Y-m-d_His') . '.sql';
        $path = $directory . DIRECTORY_SEPARATOR . $filename;

        $process = new Process([
            $pgDump,
            '--host=' . config('database.connections.pgsql.host'),
            '--port=' . config('database.connections.pgsql.port'),
            '--username=' . config('database.connections.pgsql.username'),
            '--dbname=' . config('database.connections.pgsql.database'),
            '--format=plain',
            '--no-owner',
            '--file=' . $path,
        ]);
        $process->setEnv(array_merge($_ENV, [
            'PGPASSWORD' => config('database.connections.pgsql.password'),
        ]));
        $process->setTimeout(300);
        $process->run();

        if (! $process->isSuccessful() || ! is_file($path) || filesize($path) === 0) {
            if (is_file($path)) {
                unlink($path);
            }

            return back()->withErrors([
                'backup' => 'Impossible de créer la sauvegarde : ' . trim($process->getErrorOutput()),
            ]);
        }

        return back()->with('success', 'Sauvegarde créée : ' . $filename);
    }

    public function download(string $filename)
    {
        abort_unless(auth()->user()->canManageUsers(), 403);

        $filename = basename($filename);
        $path = storage_path('app/private/backups/' . $filename);

        if (! str_ends_with(strtolower($filename), '.sql') || ! is_file($path)) {
            abort(404);
        }

        return response()->download($path, $filename, [
            'Content-Type' => 'application/sql',
        ]);
    }

    public function restore(Request $request)
    {
        abort_unless(auth()->user()->canManageUsers(), 403);

        $validated = $request->validate([
            'backup' => 'required|string',
            'confirmation' => 'required|in:RESTAURER',
        ], [
            'confirmation.in' => 'Vous devez saisir exactement RESTAURER pour confirmer.',
        ]);

        if (config('database.default') !== 'pgsql') {
            return back()->withErrors(['restore' => 'La restauration automatique est disponible uniquement avec PostgreSQL.']);
        }

        $psql = $this->postgresExecutable('psql.exe');
        if (! $psql) {
            return back()->withErrors(['restore' => 'PostgreSQL psql est introuvable sur cet ordinateur.']);
        }

        $filename = basename($validated['backup']);
        $path = storage_path('app/private/backups/' . $filename);

        if (! str_ends_with(strtolower($filename), '.sql') || ! is_file($path)) {
            return back()->withErrors(['restore' => 'La sauvegarde sélectionnée est introuvable.']);
        }

        $process = new Process([
            $psql,
            '--host=' . config('database.connections.pgsql.host'),
            '--port=' . config('database.connections.pgsql.port'),
            '--username=' . config('database.connections.pgsql.username'),
            '--dbname=' . config('database.connections.pgsql.database'),
            '--file=' . $path,
            '--set=ON_ERROR_STOP=1',
        ]);
        $process->setEnv(array_merge($_ENV, [
            'PGPASSWORD' => config('database.connections.pgsql.password'),
        ]));
        $process->setTimeout(300);
        $process->run();

        if (! $process->isSuccessful()) {
            return back()->withErrors([
                'restore' => 'La restauration a échoué : ' . trim($process->getErrorOutput()),
            ]);
        }

        return back()->with('success', 'La sauvegarde a été restaurée avec succès.');
    }

    private function postgresExecutable(string $name): ?string
    {
        $standard = 'C:\\Program Files\\PostgreSQL\\18\\bin\\' . $name;
        if (is_file($standard)) {
            return $standard;
        }

        $found = glob('C:\\Program Files\\PostgreSQL\\*\\bin\\' . $name);
        if ($found) {
            rsort($found);
            return $found[0];
        }

        return null;
    }
}
