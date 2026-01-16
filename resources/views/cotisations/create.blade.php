@extends('layouts.app')

@section('content')


<div class="form-wrapper">

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

        <!-- Sélection du membre -->
        <div class="form-group">

        <h3 class="form-title">Ajouter une cotisation</h3>
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

        <!-- Mois et Année -->
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

        <!-- Montant et Date paiement -->
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

        <!-- Boutons -->
        <div class="form-buttons mt-3">
            <button type="submit" class="btn-submit">Enregistrer</button>
            <a href="{{ route('cotisations.index') }}" class="btn-cancel">Retour</a>
        </div>
    </form>
</div>


<style>
/* WRAPPER FORMULAIRE */
.form-wrapper {
    display: flex;
    justify-content: center;
    padding: 40px 10px;
}

/* FORM CARD */
.cotisation-form {
    background: #ffffff;
    width: 100%;
    max-width: 650px;
    padding: 35px 40px;
    border-radius: 18px;
    border: 1px solid #e0e0e0;
    box-shadow: 0 12px 35px rgba(0,0,0,0.06);
}

/* TITRE */
.form-title {
    text-align: center;
    color: #2563eb; /* bleu logo */
    font-size: 22px;
    margin-bottom: 30px;
}

/* FORM GROUP */
.form-group label {
    display: block;
    font-size: 14px;
    margin-bottom: 6px;
    color: #111;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 11px 14px;
    border-radius: 10px;
    border: 1px solid #d1d5db;
    font-size: 14px;
    outline: none;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #2563eb;
}

/* FORM ROW */
.form-row {
    display: flex;
    gap: 20px;
}

.form-row .form-group {
    flex: 1;
}

/* ERREURS */
.alert-danger {
    background: #fdecea;
    color: #b91c1c;
    padding: 12px 18px;
    border-radius: 10px;
    margin-bottom: 20px;
    border: 1px solid #f5c6cb;
}

/* BOUTONS */
.btn-submit {
    background: #16a34a;
    color: #fff;
    padding: 12px 28px;
    border-radius: 10px;
    border: none;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    margin-right: 10px;
}

.btn-submit:hover {
    background: #15803d;
}

.btn-cancel {
    background: #e5e7eb;
    color: #111;
    padding: 12px 22px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 14px;
    text-align: center;
}

.btn-cancel:hover {
    background: #d1d5db;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .form-row {
        flex-direction: column;
    }

    .form-buttons {
        flex-direction: column;
        gap: 12px;
    }

    .btn-submit,
    .btn-cancel {
        width: 100%;
        text-align: center;
    }
}


</style>
@endsection
