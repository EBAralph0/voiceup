@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Donner un avis pour {{ $entreprise->nom_entreprise }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('avis.store', $entreprise->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="note">Note (sur 5)</label>
            <input type="number" name="note" id="note" class="form-control" step="0.5" min="0" max="5" required>
        </div>
        <div class="form-group">
            <label for="commentaire">Commentaire</label>
            <textarea name="commentaire" id="commentaire" class="form-control" rows="4"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Soumettre</button>
    </form>
</div>
@endsection
