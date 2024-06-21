@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails de la Demande</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            Demande #{{ $demande->id }}
        </div>
        <div class="card-body">
            <h5 class="card-title">Nom de l'entreprise: {{ $demande->nom_entreprise }}</h5>
            <p class="card-text">Utilisateur: {{ $demande->user->name }}</p>
            <p class="card-text">Date de Création: {{ $demande->created_at }}</p>
            <a href="{{ route('demandes.index') }}" class="btn btn-primary">Retour à la liste de vos demandes</a>
        </div>
    </div>
</div>
@endsection
