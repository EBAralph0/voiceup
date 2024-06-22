@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Details about the company</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            Company #{{ $demande->id }}
        </div>
        <div class="card-body">
            <h5 class="card-title">Company name: {{ $entreprise->nom_entreprise }}</h5>
            <p class="card-text">User name: {{ $demande->user->name }}</p>
            <p class="card-text">Created at: {{ $demande->created_at }}</p>
            <div class="d-flex">
                <a href="{{ route('demandes.index') }}" class="btn btn-primary mr-2">See request list</a>
                <a href="{{ route('entreprises.create', $demande->id) }}" class="btn btn-success mr-2">Create the company</a>
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
                        <a href="{{ route('demandes.reject', $demande->id) }}"class="btn btn-danger">Reject anyway</a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
