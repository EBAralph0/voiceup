@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Logo de l'entreprise arrondi et centré -->
    <div class="text-center">
        <img src="{{ $questionnaire->entreprise->logo_entreprise }}" class="rounded-circle" alt="Logo de {{ $questionnaire->entreprise->nom_entreprise }}" style="width: 150px; height: 150px; object-fit: cover;">
        <h2 class="mt-3">{{ $questionnaire->entreprise->nom_entreprise }}</h2>
    </div>

    <h2 class="mt-4">{{ $questionnaire->intitule }}</h2>
    <p>{{ $questionnaire->description }}</p>

    <form action="{{ route('responses.submit', $questionnaire->id) }}" method="POST" id="reponseForm">
        @csrf
        @foreach($questionnaire->questions as $question)
            <div class="mb-3">
                <h5>{{ $question->text }}</h5>
                @if($question->choix->isEmpty())
                    <p>No choices available for this question.</p>
                @else
                    @foreach($question->choix as $choix)
                        <div class="form-check">
                            <input class="form-check-input enlarged-radio" type="radio" name="responses[{{ $question->id }}]" id="choix-{{ $choix->id }}" value="{{ $choix->id }}" required>
                            <label class="form-check-label" for="choix-{{ $choix->id }}">
                                {{ $choix->text }}
                            </label>
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Submit Responses</button>
    </form>

    <span id="loadingIndicatorReponse" class="loading-indicator" style="display: none;">
        <div class="spinner-border text-success"><span class="visually-hidden">Loading...</span></div>
    </span>
</div>

@endsection
