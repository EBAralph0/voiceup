@extends('layouts.app')

@section('content')
<div class="container bg-white " style="max-width: 99.99%">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div> --}}
            <h1 class="mt-5">Find the company here.</h1>
            <h5 class="mt-1">You can enter a specific category instead.</h5>
            <div class="input-group mb-3 mt-5">
                <input type="text" class="form-control" placeholder="company name..." aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button">Search</button>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
