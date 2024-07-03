@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $entreprise->nom_entreprise }}</h2>
    <p>{{ $entreprise->description }}</p>

    <h3>Answer our Questionnaires</h3>
    @if($entreprise->questionnaires->isEmpty())
        <p>No questionnaires available for this company.</p>
    @else
        <div class="row">
            @foreach($entreprise->questionnaires as $questionnaire)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $questionnaire->intitule }}</h5>
                            <p class="card-text">{{ $questionnaire->description }}</p>
                            <a href="{{ route('questionnaires.questions', $questionnaire->id) }}" class="btn btn-primary position-absolute top-0 end-0 m-2">Go</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
