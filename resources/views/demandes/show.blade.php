@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Details about the request</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            Request #{{ $demande->id }}
        </div>
        <div class="card-body">
            <h5 class="card-title">Company name: {{ $demande->nom_entreprise }}</h5>
            <p class="card-text">User name: {{ $demande->user->name }}</p>
            <p class="card-text">Created at: {{ $demande->created_at }}</p>
            <div class="d-flex">
                <a href="{{ route('demandes.index') }}" class="btn btn-primary me-2">See request list</a>
                <a href="{{ route('entreprises.create', ['proprietaire_id' => $demande->user->id, 'id' => $demande->id]) }}" class="btn btn-success me-2">Create the company</a>

                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">
                    Reject the request
                </button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Reject the request ?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a href="{{ route('demandes.reject', $demande->id) }}" id="rejectRequest" class="btn btn-danger">Reject anyway</a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<span id="loadingIndicatorShowDemande" class="loading-indicator" style="display: none;">
    <div class="spinner-border text-danger"><span class="visually-hidden">Loading...</span></div>
</span>
@endsection
