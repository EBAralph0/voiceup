@extends('layouts.app')

@section('content')
<div class="d-flex mt-4">
    <div class="container">
        <h2>{{ $entreprise->nom_entreprise }}</h2>
        <p><strong>Acronym :</strong> {{ $entreprise->sigle }}</p>
        <p><strong>Company number :</strong> {{ $entreprise->numero_entreprise }}</p>
        <p><strong>Email :</strong> {{ $entreprise->mail_entreprise }}</p>
        <p><strong>Slogan :</strong> {{ $entreprise->slogan }}</p>
        <p><strong>Description :</strong> {{ $entreprise->description }}</p>
        <p><strong>Sector :</strong> {{ $entreprise->secteur->nom_secteur }}</p>
    </div>
    <div class="vr"></div>
    <div class="container">
        <h3>Add some questionnaires for this company</h3>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="questionnaireForm" action="{{ route('questionnaires.store', $entreprise->id_entreprise) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="intitule">Titled</label>
                <input type="text" name="intitule" id="intitule" class="form-control" required>
                <label for="description">Description</label>
                <input type="text" name="description" id="description" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mr-1">Create</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </form>
        <span id="loadingIndicatorQuestionnaire" class="loading-indicator" style="display: none;">
            <div class="spinner-border text-success"><span class="visually-hidden">Loading...</span></div>
        </span>
    </div>
</div>
<div class="container">
    <h3 class="mt-5">List of Questionnaires</h3>
    @if($entreprise->questionnaires->isEmpty())
        <p>No questionnaires available for this company.</p>
    @else
        <div class="row">
            @foreach($entreprise->questionnaires as $questionnaire)
                <div class="col-md-4 mb-1">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('questionnaires.detail', $questionnaire->id) }}" class="btn btn-primary position-absolute top-0 end-0 m-2">i</a>
                            <h5 class="card-title">{{ $questionnaire->intitule }}</h5>
                            <p class="card-text">{{ $questionnaire->description }}</p>
                            <p class="card-text">by: {{ $questionnaire->user->name }} - {{ $questionnaire->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

@endsection
