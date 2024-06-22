@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer une Entreprise</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
    @endif

    <form id="entrepriseForm" action="{{ route('entreprises.store', ['proprietaire_id' => $demande->user->id, 'id' => $demande->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nom_entreprise">Nom de l'entreprise</label>
            <input type="text" name="nom_entreprise" id="nom_entreprise" class="form-control" value="{{$demande->nom_entreprise}}">
        </div>
        <div class="form-group">
            <label for="sigle">Sigle</label>
            <input type="text" name="sigle" id="sigle" class="form-control">
        </div>
        <div class="form-group">
            <label for="numero_entreprise">Numéro de l'entreprise</label>
            <input type="text" name="numero_entreprise" id="numero_entreprise" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="mail_entreprise">Email de l'entreprise</label>
            <input type="email" name="mail_entreprise" id="mail_entreprise" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="logo_entreprise">Logo de l'entreprise</label>
            <input type="text" name="logo_entreprise" id="logo_entreprise" class="form-control">
        </div>
        <div class="form-group">
            <label for="slogan">Slogan</label>
            <input type="text" name="slogan" id="slogan" class="form-control">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="id_secteur">Secteur</label>
            <select name="id_secteur" id="id_secteur" class="form-control" required>
                <option></option>
                @foreach($secteurs as $s)
                <option value="{{$s->id_secteur}}">{{$s->nom_secteur}}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Créer l'entreprise</button>
    </form>
    <span id="loadingIndicatorEntreprise" class="loading-indicator" style="display: none;">
        <div class="spinner-border text-success"><span class="visually-hidden">Loading...</span></div>
    </span>
</div>
@endsection
