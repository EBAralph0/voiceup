@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $questionnaire->intitule }}</h2>
    <p>{{ $questionnaire->description }}</p>

    <form action="{{ route('responses.submit', $questionnaire->id) }}" method="POST">
        @csrf
        @foreach($questionnaire->questions as $question)
            <div class="mb-3">
                <h5>{{ $question->text }}</h5>
                @if($question->choix->isEmpty())
                    <p>No choices available for this question.</p>
                @else
                    @foreach($question->choix as $choix)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="responses[{{ $question->id }}]" id="choix-{{ $choix->id }}" value="{{ $choix->id }}" required>
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
</div>
@endsection
