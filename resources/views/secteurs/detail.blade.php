@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Questionnaire: {{ $questionnaire->intitule }} (Sector: {{ $secteur->nom_secteur }})</h2>
        <a href="{{ route('secteurs.index') }}" class="btn btn-secondary">Back to Sectors</a>
    </div>

    <p>{{ $questionnaire->description }}</p>

    <!-- Form to add a new question -->
    <h5>Add a New Question to {{ $questionnaire->intitule }}</h5>
    <form action="{{ route('questions.storeg', $questionnaire->id) }}" method="POST" class="container shadow rounded pb-2">
        @csrf
        <div class="form-group">
            <label for="text">Question</label>
            <textarea name="text" id="text" class="form-control" required></textarea>
        </div>
        <div class="form-group mt-3">
            <label for="type">Question Type</label>
            <select name="type" id="type" class="form-control" required>
                <option value="onechoice">Single choice (Radio)</option>
                <option value="multiplechoice">Multiple choices (Checkbox)</option>
                <option value="textanswer">Text answer</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Add Question</button>
    </form>

    <!-- Display questions and choices -->
    <h5 class="mt-4">Questions</h5>
    @if($questionnaire->questions->isEmpty())
        <p>No questions available for this questionnaire.</p>
    @else
        <ul class="list-group mt-3">
            @foreach($questionnaire->questions as $question)
                <li class="list-group-item">
                    <strong>{{ $question->text }}</strong>
                    @if($question->type != 'textanswer')
                        <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addChoiceModal-{{ $question->id }}">Add Choice</button>
                    @endif

                    <!-- Display choices for the question -->
                    @if($question->type != 'textanswer' && $question->choix->isNotEmpty())
                        <ul class="list-group mt-2">
                            @foreach($question->choix as $choix)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $choix->text }}
                                    <div>
                                        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editChoiceModal-{{ $choix->id }}">Edit</button>
                                        <form action="{{ route('choix.destroyg', $choix->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this choice?')">Delete</button>
                                        </form>
                                    </div>
                                </li>

                                <!-- Edit Choice Modal -->
                                <div class="modal fade" id="editChoiceModal-{{ $choix->id }}" tabindex="-1" aria-labelledby="editChoiceModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('choix.updateg', $choix->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editChoiceModalLabel">Edit Choice</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="text" name="text" class="form-control" value="{{ $choix->text }}" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </ul>
                    @endif
                </li>

                <!-- Add Choice Modal -->
                <div class="modal fade" id="addChoiceModal-{{ $question->id }}" tabindex="-1" aria-labelledby="addChoiceModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('choix.storeg', $question->id) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addChoiceModalLabel">Add Choice</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" name="text" class="form-control" placeholder="Enter choice text" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Choice</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </ul>
    @endif
</div>
@endsection
