@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Company list</h2>

    <div class="mb-3 d-flex justify-content-between">
        <select id="secteurFilter" onchange="filterBySecteur()" class="form-select me-2" style="width: 300px;">
            <option value="">All Sectors</option>
            @foreach($secteurs as $secteur)
                <option value="{{ $secteur->id_secteur }}">{{ $secteur->nom_secteur }}</option>
            @endforeach
        </select>

        <input type="text" id="searchEntreprise" onkeyup="searchEntreprise()" class="form-control" placeholder="Search companies..." style="width: 300px;">
    </div>

    <div id="entrepriseContainer" class="list-view" style="height:480px;overflow-y:scroll;">
        @foreach($entreprises as $entreprise)
            <div class="card mb-3" data-secteur="{{ $entreprise->id_secteur }}">
                <div class="card-body position-relative">
                    <div class="position-absolute top-0 end-0 m-2">
                        <a href="{{ route('entreprises.detail', $entreprise->id_entreprise) }}" class="btn btn-primary me-1"><i class="bi bi-gear-wide-connected"></i></a>
                        <a href="{{ route('entreprises.edit', $entreprise->id_entreprise) }}" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                    </div>
                    <div class="d-flex" style="align-items: center;">
                        <img class="me-2" src="{{ $entreprise->logo_entreprise }}" alt="" style="width: 50px;height:50px">
                        <div>
                            <h5 class="card-title">{{ $entreprise->nom_entreprise }}</h5>
                            <p class="card-text">{{ $entreprise->slogan }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script defer>
    function filterBySecteur() {
        const selectedSecteur = document.getElementById('secteurFilter').value;
        const cards = document.querySelectorAll('#entrepriseContainer .card');

        cards.forEach(card => {
            if (selectedSecteur) {
                card.style.display = card.getAttribute('data-secteur') === selectedSecteur ? 'block' : 'none';
            } else {
                card.style.display = 'block';
            }
        });
    }

    function searchEntreprise() {
        const value = document.getElementById('searchEntreprise').value.toLowerCase();
        const cards = document.querySelectorAll('#entrepriseContainer .card');

        cards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            card.style.display = title.includes(value) ? 'block' : 'none';
        });
    }
</script>
@endsection
