@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="d-flex w-100" style="justify-content: space-between">
        <h2>Questionaires #{{$questionnaire->id}}: {{ $questionnaire->intitule }}</h2>
        <a href="{{ route('questionnaires.dashboard', $questionnaire->id) }}" class="btn btn-primary">Dashboard</a>
    </div>

    <p>{{ $questionnaire->description }}</p>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h3 class="mt-5">Add a new question</h3>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('questions.store', $questionnaire->id) }}" method="POST" class="container shadow rounded pb-2">
        @csrf
        <div class="form-group">
            <label for="text">Question</label>
            <textarea name="text" id="text" class="form-control" required></textarea>
        </div>
        <div class="form-group mt-3">
            <label for="type">Question type</label>
            <select name="type" id="type" class="form-control" required onchange="toggleMaxValueField()">
                <option value="onechoice">Single choice (Radio)</option>
                <option value="multiplechoice">Multiples choices (Checkbox)</option>
                {{-- <option value="textanswer">Text answer</option> --}}
                <option value="numericrange">Numeric Range</option>
            </select>
        </div>

        <!-- Champ max_value caché par défaut -->
        <div class="form-group mt-3" id="max-value-field" style="display: none;">
            <label for="max_value">Max Value</label>
            <input type="number" name="max_value" id="max_value" class="form-control" min="1">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Add Question</button>
    </form>


    <h3 class="mt-3">Questions</h3>
    @if($questionnaire->questions->isEmpty())
        <p>No questions available for this questionnaire.</p>
    @else
    <div class="list-group" style="height:256px;overflow-y:scroll;">
        @foreach($questionnaire->questions as $question)
            <div class="col mb-1">
                <div class="card">
                    <div class="card-body">
                        @if($question->type != 'numericrange')
                        <div class="row position-absolute top-0 end-0 m-2">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddChoixModalCenter{{$question->id}}">+</button>
                        </div>
                        @endif
                        <h5 class="card-title">#{{$question->id}}: {{ $question->text }}</h5>
                        @if($question->type != 'numericrange')
                            <h6 class="card-subtitle mb-2 text-muted">Choices</h6>
                            @if($question->choix->isEmpty())
                                <p>No choices available for this question.</p>
                            @else
                                <ul class="d-flex list-group-flush">
                                    @foreach($question->choix as $choix)
                                        <li class="text-white me-3 p-1">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="top: 0;">
                                                {{ $choix->text }}
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li class="dropdown-item">
                                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EditChoixModalCenter{{$choix->id}}">
                                                        <i class="bi bi-pencil-fill">Edit</i>
                                                    </button>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li class="dropdown-item">
                                                    <form action="{{ route('choix.destroy', $choix->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this choice?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="bi bi-trash3-fill">Delete</i>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </li>

                                        <!-- Edit Modal moved outside of the list item -->
                                        <div class="modal fade" id="EditChoixModalCenter{{$choix->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('choix.update', $choix->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTitle">Edit Choice</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="text">Choice Text</label>
                                                                <input type="text" name="text" id="text" class="form-control" value="{{ $choix->text }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Apply</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </ul>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="AddChoixModalCenter{{$question->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="{{ route('choix.store', $question->id) }}" method="post">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Add a choice for this question #{{$question->id}}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label for="">Choice name</label>
                                <input class="form-control" type="text" name="text">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    @endif
</div>
@endsection


@section('scripts')
<script>
    function toggleMaxValueField() {
        const typeSelect = document.getElementById('type');
        const maxValueField = document.getElementById('max-value-field');
        maxValueField.style.display = typeSelect.value === 'numericrange' ? 'block' : 'none';
    }
</script>
@endsection
