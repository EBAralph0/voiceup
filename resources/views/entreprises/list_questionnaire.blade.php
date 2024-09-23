@extends('layouts.app')

@section('content')
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="star" viewBox="-2 -2 24 24">
        <path d="m10 15-5.9 3 1.1-6.5L.5 7 7 6 10 0l3 6 6.5 1-4.7 4.5 1 6.6z" />
    </symbol>
</svg>

<div class="container mt-4">
    <!-- Logo de l'entreprise arrondi et centré -->
    <div class="text-center">
        <img src="{{ $entreprise->logo_entreprise }}" class="rounded-circle" alt="Logo de {{ $entreprise->nom_entreprise }}" style="width: 150px; height: 150px; object-fit: cover;">
        <h2 class="mt-3">{{ $entreprise->nom_entreprise }}</h2>

        <!-- Note moyenne avec étoiles -->
        @php
            $avgNote = round($entreprise->avis->avg('note'), 1);
            $fullStars = floor($avgNote); // Nombres d'étoiles pleines
            $emptyStars = 5 - $fullStars; // Étoiles vides
        @endphp

        <div class="my-2">
            <!-- Afficher les étoiles -->
            @for ($i = 1; $i <= 5; $i++)
            <svg width="20" height="20" fill="{{ $i <= $avgNote ? '#ffc107' : '#6c757d' }}"> <!-- Jaune pour text-warning et gris pour text-secondary -->
                <use href="#star"></use>
            </svg>
            @endfor

            <p>{{ $avgNote }}/5</p>
        </div>
    </div>

    <!-- Section principale avec deux colonnes -->
    <div class="row mt-4">
        <!-- Colonne gauche : Liste des questionnaires avec un bouton pour voir les avis -->
        <div class="col-md-6">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Questionnaires</h3>

            </div>

            @if ($entreprise->questionnaires->isEmpty())
                <p>No questionnaire available now.</p>
            @else
                <ul class="list-group mt-3">
                    @foreach ($entreprise->questionnaires as $questionnaire)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $questionnaire->intitule }}
                            <a href="{{ route('questionnaires.questions', $questionnaire->id) }}" class="btn btn-primary">Go</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <!-- Colonne droite : Statistiques de notation -->
        <div class="col-md-6">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Rating statistics</h3>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAvis">
                    See feedbacks
                </button>
            </div>
            @php
                $ratings = [1, 2, 3, 4, 5];
                $totalAvis = $entreprise->avis->count();
            @endphp

            <ul class="list-group mt-3">
                @foreach ($ratings as $rating)
                    @php
                        $count = $entreprise->avis->where('note', $rating)->count();
                        $percentage = $totalAvis > 0 ? ($count / $totalAvis) * 100 : 0;
                    @endphp
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>{{ $rating }} Star(s)</span>
                            <span>{{ $count }} opinion(s)</span>
                        </div>
                        <div class="progress mt-2" style="height: 10px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Modal pour afficher tous les avis -->
    <div class="modal fade" id="modalAvis" tabindex="-1" role="dialog" aria-labelledby="modalAvisLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAvisLabel">{{ $entreprise->nom_entreprise }}'s comments</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($entreprise->avis->isEmpty())
                        <p>Aucun avis pour cette entreprise.</p>
                    @else
                        @foreach ($entreprise->avis as $avis)
                            <div class="card mb-3 bg-white shadow" style="border: none">
                                <div class="card-body">
                                    <h5 class="card-title">Score : {{ $avis->note }} / 5</h5>
                                    <p class="card-text">{{ $avis->commentaire }}</p>
                                    <p class="card-text">
                                        <small class="text-muted">By {{ $avis->user->name }} le {{ $avis->created_at->format('d/m/Y') }}</small>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bouton flottant pour la notation -->
    <button id="rateButton" class="btn btn-warning position-fixed" style="bottom: 20px; right: 20px; border-radius: 50%;" data-bs-toggle="modal" data-bs-target="#exampleModalCenterNote">
        <i class="bi bi-star-fill"></i>
    </button>

    <!-- Modal pour noter -->
    <div class="modal fade" id="exampleModalCenterNote" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Rate this company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('avis.store', $entreprise->id_entreprise) }}" method="POST">
                        @csrf
                        <fieldset>
                            <legend>Marks</legend>
                            <input type="hidden" name="note" id="note" value="-1" required>
                            <input type="hidden" name="id" value="sessionID">
                            <p class="wrapper-rating">
                                <input name="note" id="note_0" value="-1" type="radio" checked autofocus>
                                <span class="star">
                                    <input name="note" id="note_1" value="1" type="radio">
                                    <label for="note_1" title="Très mauvaise"><svg><use href="#star"></use></svg></label>
                                    <span class="star">
                                        <input name="note" id="note_2" value="2" type="radio">
                                        <label for="note_2" title="Médiocre"><svg><use href="#star"></use></svg></label>
                                        <span class="star">
                                            <input name="note" id="note_3" value="3" type="radio">
                                            <label for="note_3" title="Moyenne"><svg><use href="#star"></use></svg></label>
                                            <span class="star">
                                                <input name="note" id="note_4" value="4" type="radio">
                                                <label for="note_4" title="Bonne"><svg><use href="#star"></use></svg></label>
                                                <span class="star">
                                                    <input name="note" id="note_5" value="5" type="radio">
                                                    <label for="note_5" title="Excellente"><svg><use href="#star"></use></svg></label>
                                                </span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </p>
                            <div class="form-group">
                                <label for="commentaire">Comment</label>
                                <textarea name="commentaire" id="commentaire" class="form-control" rows="4"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mt-1">Submit</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('input[name="note_radio"]').forEach((elem) => {
        elem.addEventListener('change', function() {
            document.getElementById('note').value = this.value;
        });
    });
</script>
@endsection
