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

        <div class="mb-3">
            <label>Membre</label>
            <input type="text" class="form-control"
                   value="{{ $cotisation->membre->nom }} {{ $cotisation->membre->prenom }}"
                   disabled>
        </div>

        <div class="mb-3">
            <label>Mois</label>
            <select name="mois" class="form-control" required>
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}"
                        {{ $cotisation->mois == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label>Année</label>
            <input type="number" name="annee"
                   class="form-control"
                   value="{{ $cotisation->annee }}" required>
        </div>

        <div class="mb-3">
            <label>Montant (max 1000)</label>
            <input type="number" name="montant"
                   class="form-control"
                   value="{{ $cotisation->montant }}"
                   max="1000" required>
        </div>

        <div class="mb-3">
            <label>Date de paiement</label>
            <input type="date" name="date_paiement"
                   class="form-control"
                   value="{{ $cotisation->date_paiement }}" required>
        </div>

        <button class="btn btn-success">Mettre à jour</button>
        <a href="{{ route('cotisations.index') }}" class="btn btn-secondary">
            Annuler
        </a>
    </form>
</div>
@endsection
