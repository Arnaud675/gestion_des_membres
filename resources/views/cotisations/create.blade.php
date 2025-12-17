@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Ajouter une cotisation</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cotisations.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Membre</label>
            <select name="membre_id" class="form-control" required>
                <option value="">-- Choisir un membre --</option>
                @foreach($membres as $membre)
                    <option value="{{ $membre->id }}">
                        {{ $membre->nom }} {{ $membre->prenom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Mois</label>
            <select name="mois" class="form-control" required>
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label>Année</label>
            <input type="number" name="annee" class="form-control"
                   value="{{ date('Y') }}" required>
        </div>

        <div class="mb-3">
            <label>Montant (max 1000)</label>
            <input type="number" name="montant" class="form-control"
                   max="1000" required>
        </div>

        <div class="mb-3">
            <label>Date de paiement</label>
            <input type="date" name="date_paiement" class="form-control"
                   value="{{ date('Y-m-d') }}" required>
        </div>

        <button class="btn btn-success">Enregistrer</button>
        <a href="{{ route('cotisations.index') }}" class="btn btn-secondary">
            Retour
        </a>
    </form>
</div>
@endsection
