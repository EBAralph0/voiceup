@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">
        <i class="bi bi-arrow-left-circle"></i> Back
    </a>

    <!-- Logo de l'entreprise -->
    <div class="text-center">
        <img src="{{ $entreprise->logo_entreprise }}" class="rounded-circle" alt="Logo de {{ $entreprise->nom_entreprise }}" style="width: 150px; height: 150px; object-fit: cover;">
        <h2 class="mt-3">{{ $entreprise->nom_entreprise }}</h2>
    </div>

    <h2 class="mt-4">{{ $questionnaire->intitule }}</h2>
    <p>{{ $questionnaire->description }}</p>

    <form action="{{ route('responses.submit', ['id' => $questionnaire->id, 'entreprise' => $entreprise->id_entreprise]) }}" method="POST" id="reponseForm">
        @csrf

        <!-- Affichage des questions du questionnaire de secteur -->
        @foreach($questionnaire->questions as $question)
            <div class="mb-3">
                <h5>{{ $question->text }}</h5>
                @include('partials.question_choices', ['question' => $question])
            </div>
        @endforeach

        <!-- Affichage des questions du questionnaire le plus récent de l'entreprise -->
        @if($latestQuestionnaire)
            <h4 class="mt-4">{{ $latestQuestionnaire->intitule }} - Additional Questions</h4>
            @foreach($latestQuestionnaire->questions as $question)
                <div class="mb-3">
                    <h5>{{ $question->text }}</h5>
                    @include('partials.question_choices', ['question' => $question])
                </div>
            @endforeach
        @endif

        <div class="mb-3">
            <label for="suggestion" class="form-label">Suggestions</label>
            <textarea class="form-control" name="suggestion" id="suggestion" rows="2"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Responses</button>
    </form>

    <span id="loadingIndicatorReponse" class="loading-indicator" style="display: none;">
        <div class="spinner-border text-warning"><span class="visually-hidden">Loading...</span></div>
    </span>
</div>
@endsection
