@extends('layouts.app')

@section('content')
<div class="form-wrapper">

    <h3>Ajouter une cotisation</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cotisations.store') }}" method="POST" class="cotisation-form">
        @csrf

        <div class="form-group">
            <label>Membre</label>
            <select name="member_id" class="form-control" required>
                <option value="">-- Choisir un membre --</option>
                @foreach($members as $member)
                    <option value="{{ $member->id }}">
                        {{ $member->nom }} {{ $member->prenoms }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Mois</label>
                <select name="mois" class="form-control" required>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="form-group">
                <label>Année</label>
                <input type="number" name="annee" class="form-control" value="{{ date('Y') }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Montant (max 1000)</label>
                <input type="number" name="montant" class="form-control" max="1000" required>
            </div>

            <div class="form-group">
                <label>Date de paiement</label>
                <input type="date" name="date_paiement" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
        </div>

        <div class="form-buttons mt-3">
            <button class="btn-submit">Enregistrer</button>
            <a href="{{ route('cotisations.index') }}" class="btn-cancel">Retour</a>
        </div>
    </form>
</div>

<style>
.form-wrapper {
    background: #fff;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.cotisation-form .form-group {
    margin-bottom: 15px;
}

.form-row {
    display: flex;
    gap: 15px;
}

.cotisation-form label {
    font-weight: 500;
    margin-bottom: 5px;
    display: block;
}

.cotisation-form input, 
.cotisation-form select {
    width: 100%;
    padding: 10px 12px;
    border-radius: 8px;
    border: 2px solid #1e5aa8;
    outline: none;
    transition: 0.3s;
}

.cotisation-form input:focus, .cotisation-form select:focus {
    border-color: #2e8b57;
    box-shadow: 0 0 6px rgba(46,139,87,0.4);
}

.btn-submit, .btn-cancel {
    padding: 10px 18px;
    border-radius: 30px;
    border: none;
    font-weight: 500;
    cursor: pointer;
    transition: 0.3s;
}

.btn-submit {
    background: linear-gradient(135deg, #f4c430, #1e5aa8);
    color: #fff;
}

.btn-submit:hover {
    background: linear-gradient(135deg, #1e5aa8, #2e8b57);
    transform: translateY(-2px);
}

.btn-cancel {
    background: #6c757d;
    color: #fff;
    text-decoration: none;
    display: inline-block;
    margin-left: 10px;
}

.btn-cancel:hover {
    background: #5a6268;
}
</style>
@endsection
