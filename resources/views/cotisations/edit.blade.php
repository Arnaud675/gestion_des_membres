@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Modifier la cotisation</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cotisations.update', $cotisation->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Champ caché pour member_id (important pour la validation) -->
        <input type="hidden" name="member_id" value="{{ $cotisation->member_id }}">

        <div class="mb-3">
            <label>Membre</label>
            <input type="text" class="form-control"
                   value="{{ $cotisation->member->nom }} {{ $cotisation->member->prenom }}"
                   disabled>
            <small class="text-muted">Le membre ne peut pas être modifié</small>
        </div>

        <div class="mb-3">
            <label>Mois</label>
            <select name="mois" class="form-control" required>
                @php
                    $moisNoms = [
                        1 => 'Janvier',
                        2 => 'Février',
                        3 => 'Mars',
                        4 => 'Avril',
                        5 => 'Mai',
                        6 => 'Juin',
                        7 => 'Juillet',
                        8 => 'Août',
                        9 => 'Septembre',
                        10 => 'Octobre',
                        11 => 'Novembre',
                        12 => 'Décembre'
                    ];
                @endphp
                @foreach($moisNoms as $numero => $nom)
                    <option value="{{ $numero }}" {{ $cotisation->mois == $numero ? 'selected' : '' }}>
                        {{ $nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Année</label>
            <input type="number" name="annee"
                   class="form-control"
                   value="{{ $cotisation->annee }}" 
                   min="2020"
                   required>
        </div>

        <div class="mb-3">
            <label>Montant (max 1000 FCFA)</label>
            <input type="number" name="montant"
                   class="form-control"
                   value="{{ $cotisation->montant }}"
                   min="0"
                   max="1000" 
                   step="0.01"
                   required>
        </div>

        <div class="mb-3">
            <label>Date de paiement</label>
            <input type="date" name="date_paiement"
                   class="form-control"
                   value="{{ \Carbon\Carbon::parse($cotisation->date_paiement)->format('Y-m-d') }}" 
                   required>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Mettre à jour</button>
            <a href="{{ route('cotisations.index') }}" class="btn btn-secondary">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection

<style>
    /* WRAPPER */
    .container {
        display: flex;
        justify-content: center;
        padding: 40px 10px;
        flex-direction: column;
        align-items: center;
    }

    /* FORM CARD */
    form {
        background: #ffffff;
        width: 100%;
        max-width: 650px;
        padding: 35px 40px;
        border-radius: 18px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 12px 35px rgba(0,0,0,0.08);
    }

    /* TITRE */
    .container h3 {
        text-align: center;
        color: #2563eb;
        font-size: 22px;
        margin-bottom: 30px;
        width: 100%;
        max-width: 650px;
    }

    /* FORM GROUP */
    .mb-3 label {
        display: block;
        font-size: 14px;
        margin-bottom: 6px;
        color: #111;
        font-weight: 500;
    }

    .mb-3 input,
    .mb-3 select {
        width: 100%;
        padding: 11px 14px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
        font-size: 14px;
        outline: none;
        transition: border-color 0.3s;
    }

    .mb-3 input:focus,
    .mb-3 select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .mb-3 input[disabled] {
        background: #f8fafc;
        cursor: not-allowed;
        color: #666;
    }

    .text-muted {
        font-size: 12px;
        color: #6b7280;
        margin-top: 4px;
        display: block;
    }

    /* ERREURS */
    .alert-danger {
        background: #fef2f2;
        color: #dc2626;
        padding: 12px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
        border: 1px solid #fecaca;
        width: 100%;
        max-width: 650px;
    }

    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }

    /* BOUTONS */
    .btn-success {
        background: #16a34a;
        color: #fff;
        padding: 12px 28px;
        border-radius: 10px;
        border: none;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.3s;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-success:hover {
        background: #15803d;
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #111;
        padding: 12px 22px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        display: inline-block;
        text-align: center;
        transition: background 0.3s;
    }

    .btn-secondary:hover {
        background: #d1d5db;
    }

    .d-flex {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        form {
            padding: 25px 20px;
            margin: 0 10px;
        }

        .container h3 {
            padding: 0 10px;
        }

        .d-flex {
            flex-direction: column;
        }

        .btn-success,
        .btn-secondary {
            width: 100%;
            margin-bottom: 10px;
        }
    }

    @media (max-width: 480px) {
        form {
            padding: 20px 15px;
        }

        .container h3 {
            font-size: 20px;
        }
    }
</style>