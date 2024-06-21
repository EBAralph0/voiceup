@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Send us a company request</h1>
    <h1></h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
    @endif

    <form id="demandeForm" action="{{ route('demandes.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nom_entreprise">Company name</label>
            <input type="text" name="nom_entreprise" id="nom_entreprise" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-4">Send the request</button>
    </form>
    <span id="loadingIndicator" class="loading-indicator" style="display: none;">
          <div class="spinner-border text-warning"><span class="visually-hidden">Loading...</span></div>
    </span>
</div>

@endsection
