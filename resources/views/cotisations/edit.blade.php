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
            <label>member</label>
            <input type="text" class="form-control"
                   value="{{ $cotisation->member->nom }} {{ $cotisation->member->prenom }}"
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

<style>

    /* WRAPPER */
.container {
    display: flex;
    justify-content: center;
    padding: 40px 10px;
}

/* FORM CARD */
form {
    background: #ffffff;
    width: 100%;
    max-width: 650px;
    padding: 35px 40px;
    border-radius: 18px;
    border: 1px solid var(--border-soft);
    box-shadow: 0 12px 35px rgba(0,0,0,0.08);
}

/* TITRE */
.container h3 {
    text-align: center;
    color: var(--blue);
    font-size: 22px;
    margin-bottom: 30px;
}

/* FORM GROUP */
.mb-3 label {
    display: block;
    font-size: 14px;
    margin-bottom: 6px;
    color: var(--black);
}

.mb-3 input,
.mb-3 select {
    width: 100%;
    padding: 11px 14px;
    border-radius: 10px;
    border: 1px solid var(--border-soft);
    font-size: 14px;
    outline: none;
}

.mb-3 input:focus,
.mb-3 select:focus {
    border-color: var(--blue);
}

.mb-3 input[disabled] {
    background: #f5f6fa;
    cursor: not-allowed;
}

/* ERREURS */
.alert-danger {
    background: #fdecea;
    color: var(--red);
    padding: 12px 18px;
    border-radius: 10px;
    margin-bottom: 20px;
    border: 1px solid #f5c6cb;
}

/* BOUTONS */
.btn-success {
    background: var(--green);
    color: #fff;
    padding: 12px 28px;
    border-radius: 10px;
    border: none;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    margin-right: 10px;
}

.btn-success:hover {
    background: #168a4a;
}

.btn-secondary {
    background: #e5e7eb;
    color: var(--black);
    padding: 12px 22px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 14px;
}

.btn-secondary:hover {
    background: #d1d5db;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    form {
        padding: 25px;
    }

    .btn-success,
    .btn-secondary {
        width: 100%;
        margin-bottom: 12px;
        text-align: center;
    }
}

</style>
