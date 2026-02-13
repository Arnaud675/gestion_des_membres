@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<div class="card dashboard">

    <div class="dashboard-header">
        <h1>Dashboard Admin</h1>
        <span class="badge-admin">Admin</span>
    </div>

    <p class="dashboard-welcome">
        Bienvenue <strong>{{ auth()->user()->name }}</strong>  
        Nous sommes heureux de vous revoir.
    </p>

    <div class="dashboard-actions">
        @if (!auth()->user()->isAdmin())
            
        
        <a href="{{ route('members.create') }}" class="btn-dashboard">
            ➕ Ajouter un membre
        </a>

        @endif

         <a href="{{ route('cotisations.index') }}" class="btn-dashboard">
             Voir les cotisations
        </a>

        <a href="{{ route('members.index') }}" class="btn-secondary">
             Voir les membres
        </a>
    </div>

</div>

@endsection

<style>

   /* DASHBOARD ADMIN */
.dashboard {
    padding: 30px;
}

/* HEADER */
.dashboard-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.dashboard-header h1 {
    font-size: 24px;
    color: var(--blue);
}

/* BADGE ADMIN */
.badge-admin {
    background: var(--yellow);
    color: var(--black);
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
}

/* MESSAGE DE BIENVENUE */
.dashboard-welcome {
    font-size: 16px;
    color: #555;
    margin-bottom: 30px;
}

.dashboard-welcome strong {
    color: var(--black);
}

/* ACTIONS */
.dashboard-actions {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

/* BOUTON PRINCIPAL */
.btn-dashboard {
    background: var(--green);
    color: #fff;
    padding: 12px 22px;
    border-radius: 12px;
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
    transition: 0.25s;
}

.btn-dashboard:hover {
    background: #168a4a;
}

/* BOUTON SECONDAIRE */
.btn-secondary {
    background: var(--blue);
    color: #fff;
    padding: 12px 22px;
    border-radius: 12px;
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
    transition: 0.25s;
}

.btn-secondary:hover {
    background: #183fb4;
}


</style>