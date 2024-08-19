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
                <th>Company name</th>
                <th>Created by</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($demandes as $demande)
                <tr class="perso_tr">
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
                        <td><a href="{{ route('demandes.show', $demande->id) }}" class="btn btn-primary"><i class="bi bi-pencil">Consulter</i></a></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
