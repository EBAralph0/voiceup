@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Demandes</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom de l'entreprise</th>
                <th>Utilisateur</th>
                <th>Date de Création</th>
            </tr>
        </thead>
        <tbody>
            @foreach($demandes as $demande)
                <tr>
                    <td>{{ $demande->id }}</td>
                    <td>{{ $demande->nom_entreprise }}</td>
                    <td>{{ $demande->user->name }}</td>
                    <td>{{ $demande->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
