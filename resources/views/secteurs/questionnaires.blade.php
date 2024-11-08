@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mt-2 d-flex">
        <a href="{{ url("/secteurs")}}" class="btn btn-secondary me-2">
            <i class="bi bi-arrow-left-circle"></i> Back
        </a>
        <h3>Questionnaires for Sector: {{ $secteur->nom_secteur }}</h3>
    </div>

    <!-- Bouton pour créer un nouveau questionnaire -->
    <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#createQuestionnaireModal">Add Questionnaire</button>

    <!-- Liste des questionnaires -->
    @if($secteur->questionnaires->isEmpty())
        <p>No questionnaires available for this sector.</p>
    @else
        <ul class="list-group">
            @foreach($secteur->questionnaires as $questionnaire)
                <li class="list-group-item d-flex justify-content-between align-items-center m-2">
                    {{ $questionnaire->intitule }}
                    <div>
                        <!-- Detail Questionnaires -->
                        <button class="btn btn-success btn-sm me-1" onclick="window.location='{{ route('secteurs.detail', $questionnaire->id) }}'">
                            <i class="bi bi-gear"> Build</i>
                        </button>

                        <!-- Edit Button -->
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editQuestionnaireModal-{{ $questionnaire->id }}">Edit</button>

                        <!-- Delete Button -->
                        <button class="btn btn-danger btn-sm ms-1" data-bs-toggle="modal" data-bs-target="#deleteQuestionnaireModal-{{ $questionnaire->id }}">Delete</button>
                    </div>
                </li>

                <!-- Edit Questionnaire Modal -->
                <div class="modal fade" id="editQuestionnaireModal-{{ $questionnaire->id }}" tabindex="-1" aria-labelledby="editQuestionnaireModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('questionnaires.update', $questionnaire->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editQuestionnaireModalLabel">Edit Questionnaire</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="intitule">Title</label>
                                        <input type="text" name="intitule" id="intitule" class="form-control" value="{{ $questionnaire->intitule }}" required>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control" rows="3" required>{{ $questionnaire->description }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Questionnaire Modal -->
                <div class="modal fade" id="deleteQuestionnaireModal-{{ $questionnaire->id }}" tabindex="-1" aria-labelledby="deleteQuestionnaireModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('questionnaires.destroy', $questionnaire->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteQuestionnaireModalLabel">Delete Questionnaire</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this questionnaire?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </ul>
    @endif
</div>

<!-- Create Questionnaire Modal -->
<div class="modal fade" id="createQuestionnaireModal" tabindex="-1" aria-labelledby="createQuestionnaireModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('secteurs.questionnaires.store', $secteur->id_secteur) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createQuestionnaireModalLabel">Add New Questionnaire</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="intitule">Title</label>
                        <input type="text" name="intitule" id="intitule" class="form-control" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Questionnaire</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
