@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Questionaires #{{$questionnaire->id}}: {{ $questionnaire->intitule }}</h2>
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

    <form action="{{ route('questions.store', $questionnaire->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="text">Question</label>
            <textarea name="text" id="text" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Question</button>
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
                            {{-- <a href="{{ route('questions.detail', $question->id) }}" class="btn btn-primary ">i</a> --}}
                            <div class="row position-absolute top-0 end-0 m-2">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#AddChoixModalCenter{{$question->id}}">+</button>
                            </div>
                            <h5 class="card-title">#{{$question->id}}: {{ $question->text }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Choices</h6>
                            @if($question->choix->isEmpty())
                                <p>No choices available for this question.</p>
                            @else
                                <ul class="d-flex list-group-flush">
                                    @foreach($question->choix as $choix)
                                        <li class="card bg-dark text-white ml-2 p-1">{{ $choix->text }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="AddChoixModalCenter{{$question->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <form action="{{ route('choix.store', $question->id) }}" method="post">
                            @csrf
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add a choice for this question #{{$question->id}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <label for="">Choice name</label>
                                <input class="form-control" type="text" name="text">
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
