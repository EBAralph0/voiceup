
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer un Questionnaire pour {{$entreprise->nom_entreprise}}</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('questionnaires.store', $entreprise_id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="intitule">Intitulé</label>
            <input type="text" name="intitule" id="intitule" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Créer le questionnaire</button>
    </form>
</div>
@endsection
