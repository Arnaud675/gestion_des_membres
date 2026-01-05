@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<div class="card dashboard">

    <div class="dashboard-header">
        <h1>Dashboard Admin</h1>
        <span class="badge-admin">Admin</span>
    </div>

    <p class="dashboard-welcome">
        Bienvenue <strong>{{ auth()->user()->name }}</strong> 👋  
        Nous sommes heureux de vous revoir.
    </p>

    <div class="dashboard-actions">
        <a href="{{ route('members.create') }}" class="btn-dashboard">
            ➕ Ajouter un membre
        </a>

        <a href="{{ route('members.index') }}" class="btn-secondary">
            👥 Voir les membres
        </a>
    </div>

</div>

@endsection

<style>

    /* ===== DASHBOARD ===== */
.dashboard {
    max-width: 100%;
}

.dashboard-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 15px;
}

.dashboard-header h1 {
    margin: 0;
    color: #1e5aa8;
    font-size: 26px;
}

.badge-admin {
    background: #2e8b57;
    color: #ffffff;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
}

.dashboard-welcome {
    font-size: 16px;
    margin-bottom: 30px;
    color: #333;
}

.dashboard-actions {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

/* Boutons */
.btn-dashboard {
    padding: 12px 25px;
    background: linear-gradient(135deg, #f4c430, #1e5aa8);
    color: #ffffff;
    text-decoration: none;
    border-radius: 30px;
    font-weight: 600;
    transition: 0.3s;
}

.btn-dashboard:hover {
    background: linear-gradient(135deg, #1e5aa8, #2e8b57);
    transform: translateY(-2px);
}

.btn-secondary {
    padding: 12px 25px;
    background: #ffffff;
    color: #1e5aa8;
    border: 2px solid #1e5aa8;
    text-decoration: none;
    border-radius: 30px;
    font-weight: 600;
    transition: 0.3s;
}

.btn-secondary:hover {
    background: #1e5aa8;
    color: #ffffff;
}

</style>