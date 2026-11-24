<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CotisationController;
use App\Http\Controllers\Members\MemberController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\DatabaseBackupController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');
});


Route::middleware('auth')->group(function () {
    Route::resource('members', MemberController::class);
});

Route::middleware('auth')->group(function () {
    Route::resource('cotisations', CotisationController::class);
});


Route::middleware('auth')->group(function () {
    Route::get('cotisations-retards', [CotisationController::class, 'retards'])
        ->name('cotisations.retards');

    Route::get(
        'members/{member}/cotisations',
        [CotisationController::class, 'parMembre']
    )->name('members.cotisations');

    // Gestion des dépenses
    Route::prefix('depenses')->name('depenses.')->group(function () {
        Route::get('/', [DepenseController::class, 'index'])->name('index');
        Route::get('/create', [DepenseController::class, 'create'])->name('create');
        Route::post('/', [DepenseController::class, 'store'])->name('store');
        Route::get('/{depense}', [DepenseController::class, 'show'])->name('show');
        Route::get('/{depense}/edit', [DepenseController::class, 'edit'])->name('edit');
        Route::put('/{depense}', [DepenseController::class, 'update'])->name('update');
        Route::delete('/{depense}', [DepenseController::class, 'destroy'])->name('destroy');
    });

    // Historique des actions
    Route::get('audit-log', [AuditLogController::class, 'index'])->name('audit.log');
    Route::get('/historique-actions', [AuditLogController::class, 'index'])
        ->name('audit.index');

    // Gestion des utilisateurs et rôles
    Route::get('/administration/utilisateurs', [UserRoleController::class, 'index'])
        ->name('admin.users');
    Route::put('/administration/utilisateurs/{user}/role', [UserRoleController::class, 'update'])
        ->name('admin.users.role.update');
    Route::put('/administration/utilisateurs/{user}/mot-de-passe', [UserRoleController::class, 'resetPassword'])
        ->name('admin.users.password.reset');
    Route::post('/administration/utilisateurs', [UserRoleController::class, 'store'])
        ->name('admin.users.store');
    Route::delete('/administration/utilisateurs/{user}', [UserRoleController::class, 'destroy'])
        ->name('admin.users.destroy');
});

// Sauvegarde et restauration PostgreSQL
Route::middleware('auth')->group(function () {
    Route::get('/administration/sauvegarde', [DatabaseBackupController::class, 'index'])
        ->name('admin.backup.index');
    Route::post('/administration/sauvegarde', [DatabaseBackupController::class, 'createBackup'])
        ->name('admin.backup.create');
    Route::get('/administration/sauvegarde/{filename}/telecharger', [DatabaseBackupController::class, 'download'])
        ->where('filename', '[A-Za-z0-9_.-]+')
        ->name('admin.backup.download');
    Route::post('/administration/restauration', [DatabaseBackupController::class, 'restore'])
        ->name('admin.backup.restore');
});

Route::middleware('auth')->group(function () {
    Route::get('/membres/archives', [MemberController::class, 'archived'])
        ->name('members.archived');
    Route::post('/membres/{member}/archiver', [MemberController::class, 'archive'])
        ->name('members.archive');
    Route::post('/membres/{member}/restaurer', [MemberController::class, 'restore'])
        ->name('members.restore');

    Route::get('/membres/import-export/csv', [MemberController::class, 'importForm'])
        ->name('members.import.form');
    Route::post('/membres/import-export/csv', [MemberController::class, 'importCsv'])
        ->name('members.import.csv');
    Route::get('/membres/export/csv', [MemberController::class, 'exportCsv'])
        ->name('members.export.csv');
});