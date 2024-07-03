@extends('layouts.app')

@section('content')
<div class="container" >
    <h2>Company list</h2>

    <button id="toggleViewBtn" class="btn btn-secondary mb-4"><i class="fs-4 bi-bars">...</i></button>
    <button class="btn"><i class="fa fa-bars"></i></button>
    <div id="entrepriseContainer" class="list-view" style="height:480px;overflow-y:scroll;">
        @foreach($entreprises as $entreprise)
            <div class="card mb-3">
                <div class="card-body position-relative">
                    <a href="{{ route('entreprises.detail', $entreprise->id_entreprise) }}" class="btn btn-primary position-absolute top-0 end-0 m-2">i</a>
                    <div class="d-flex" style="align-items: center;">
                        <img class="mr-2" src="{{ $entreprise->logo_entreprise }}" alt="" srcset="" style="width: 50px;height:50px">
                        <div>
                            <h5 class="card-title">{{ $entreprise->nom_entreprise }}</h5>
                            <p class="card-text">{{ $entreprise->slogan }}</p>
                        </div>
                    </div>


                    {{-- <p class="card-text">{{ $entreprise->description }}</p> --}}
                </div>
            </div>

        @endforeach
    </div>
</div>
@endsection
