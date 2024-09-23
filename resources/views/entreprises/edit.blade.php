@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex mt-2 mb-1" style="align-items: center">
        <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">
            <i class="bi bi-arrow-left-circle"></i> Back
        </a>
        <h2>Edit Company</h2>
    </div>

    <form id="entrepriseForm" action="{{ route('entreprises.update', $entreprise->id_entreprise) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Nom de l'entreprise et Sigle -->
            <div class="col-md-6 mb-3">
                <label for="nom_entreprise">Nom de l'entreprise</label>
                <input type="text" name="nom_entreprise" id="nom_entreprise" class="form-control" value="{{ $entreprise->nom_entreprise }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="sigle">Sigle</label>
                <input type="text" name="sigle" id="sigle" class="form-control" value="{{ $entreprise->sigle }}" required>
            </div>
        </div>
        <div class="row">
            <!-- Numéro de l'entreprise et Email -->
            <div class="col-md-6 mb-3">
                <label for="numero_entreprise">Numéro de l'entreprise</label>
                <input type="text" name="numero_entreprise" id="numero_entreprise" class="form-control" value="{{ $entreprise->numero_entreprise }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="mail_entreprise">Email de l'entreprise</label>
                <input type="email" name="mail_entreprise" id="mail_entreprise" class="form-control" value="{{ $entreprise->mail_entreprise }}" required>
            </div>
        </div>
        <div class="row">
            <!-- Slogan et Secteur -->
            <div class="col-md-6 mb-3">
                <label for="slogan">Slogan</label>
                <input type="text" name="slogan" id="slogan" class="form-control" value="{{ $entreprise->slogan }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="id_secteur">Secteur</label>
                <select name="id_secteur" id="id_secteur" class="form-control" required>
                    @foreach($secteurs as $s)
                        <option value="{{ $s->id_secteur }}" {{ $entreprise->id_secteur == $s->id_secteur ? 'selected' : '' }}>{{ $s->nom_secteur }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <!-- Logo et Description -->
            <div class="col-md-6 mb-3">
                <label for="logo_entreprise">Logo de l'entreprise (URL)</label>
                <input type="text" name="logo_entreprise" id="logo_entreprise" class="form-control" value="{{ $entreprise->logo_entreprise }}" onchange="previewLogo()">
                <img id="logoPreview" src="{{ $entreprise->logo_entreprise ?? asset('images/voiceup.png') }}" alt="Logo preview" class="mt-2" style="width: 150px; height: auto; display: block;">
            </div>
            <div class="col-md-6 mb-3">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4">{{ $entreprise->description }}</textarea>
            </div>
        </div>
        <div class="row">
            <!-- Date d'anniversaire -->
            <div class="form-group col-md-4">
                <label for="date_anniversaire">Date d'anniversaire</label>
                <input type="date" name="date_anniversaire" id="date_anniversaire" class="form-control" value="{{ $entreprise->date_anniversaire}}">
            </div>

            <!-- Siège social -->
            <div class="form-group col-md-4">
                <label for="siege_social">Siège social</label>
                <input type="text" name="siege_social" id="siege_social" class="form-control" value="{{ $entreprise->siege_social }}">
            </div>

            <!-- Nombre d'employés (intervalle) -->
            <div class="form-group col-md-4">
                <label for="nb_employes_interval">Nombre d'employés</label>
                <select name="nb_employes_interval" id="nb_employes_interval" class="form-control">
                    <option value="" {{ $entreprise->nb_employes_interval == '' ? 'selected' : '' }}>Select Interval</option>
                    <option value="1-10" {{ $entreprise->nb_employes_interval == '1-10' ? 'selected' : '' }}>1-10 employés</option>
                    <option value="11-50" {{ $entreprise->nb_employes_interval == '11-50' ? 'selected' : '' }}>11-50 employés</option>
                    <option value="51-200" {{ $entreprise->nb_employes_interval == '51-200' ? 'selected' : '' }}>51-200 employés</option>
                    <option value="201-500" {{ $entreprise->nb_employes_interval == '201-500' ? 'selected' : '' }}>201-500 employés</option>
                    <option value="501+" {{ $entreprise->nb_employes_interval == '501+' ? 'selected' : '' }}>501+ employés</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Update Company</button>
    </form>

    <!-- Loading Indicator -->
    <span id="loadingIndicatorEntreprise" class="loading-indicator" style="display: none;">
        <div class="spinner-border text-warning"><span class="visually-hidden">Loading...</span></div>
    </span>
</div>
@endsection

@section('scripts')
<script>
    function previewLogo() {
        const logoInput = document.getElementById('logo_entreprise');
        const logoPreview = document.getElementById('logoPreview');

        const logoUrl = logoInput.value.trim();
        if (logoUrl) {
            logoPreview.src = logoUrl;
        } else {
            logoPreview.src = '{{ asset("images/voiceup.png") }}';
        }
    }
</script>
@endsection
