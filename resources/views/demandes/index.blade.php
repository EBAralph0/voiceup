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

    <table class="table" id="liste_demande">
        <thead class="mb-2" style="border-style:none;">
            <tr>
                <th>ID</th>
                <th>Nom de l'entreprise</th>
                <th>Utilisateur</th>
                <th>Date de Création</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($demandes as $demande)
                <tr class="perso_tr">
                    <td>{{ $demande->id }}</td>
                    <td>{{ $demande->nom_entreprise }}</td>
                    <td>{{ $demande->user->name }}</td>
                    <td>{{ $demande->created_at }}</td>
                    @if ($demande->statut == "validated")
                        <td><div class="text-success">Validated</div></td>
                        <td>ok</td>
                    @elseif ($demande->statut == "rejected")
                        <td><div class="text-danger">Rejected</div></td>
                        <td>ok</td>
                    @elseif ($demande->statut == "waiting")
                        <td><div class="">Waiting</div></td>
                        <td><a href="{{ route('demandes.show', $demande->id) }}" class="">Consulter</a></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
