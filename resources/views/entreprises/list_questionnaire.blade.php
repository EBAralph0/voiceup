@extends('layouts.app')

@section('content')
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="star" viewBox="-2 -2 24 24">
            <path d="m10 15-5.9 3 1.1-6.5L.5 7 7 6 10 0l3 6 6.5 1-4.7 4.5 1 6.6z" />
        </symbol>
    </svg>
    <div class="container mt-2">

        <div class="d-flex" style="justify-content: space-between;">
            <h2>{{ $entreprise->nom_entreprise }}</h2>
            <button type="button" class="btn btn-primary" data-toggle="modal"
                data-target="#exampleModalCenterNote">Noter</button>

        </div>
        <div class="modal fade" id="exampleModalCenterNote" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Rate this company</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
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
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <p>{{ $entreprise->description }}</p>

        <h3 class="mt-5">Avis</h3>
        @if ($entreprise->avis->isEmpty())
            <p>Aucun avis pour cette entreprise.</p>
        @else
            <h5 class="text-blue">Notes : {{ $entreprise->avis->avg('note') }}/5</h5>

            <!-- Bouton pour ouvrir le modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAvis">
                Voir tous les avis
            </button>

            <!-- Modal pour afficher tous les avis -->
            <div class="modal fade" id="modalAvis" tabindex="-1" role="dialog" aria-labelledby="modalAvisLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalAvisLabel">Avis pour {{ $entreprise->nom }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="max-height: 500px;overflow-y: scroll;">
                            @foreach ($entreprise->avis as $avis)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Note : {{ $avis->note }} / 5</h5>
                                        <p class="card-text">{{ $avis->commentaire }}</p>
                                        <p class="card-text"><small class="text-muted">Par {{ $avis->user->name }} le
                                                {{ $avis->created_at->format('d/m/Y') }}</small></p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <h3 class="mt-5">Answer our Questionnaires</h3>
        @if ($entreprise->questionnaires->isEmpty())
            <p>No questionnaires available for this company.</p>
        @else
            <div class="row">
                @foreach ($entreprise->questionnaires as $questionnaire)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $questionnaire->intitule }}</h5>
                                <p class="card-text">{{ $questionnaire->description }}</p>
                                <a href="{{ route('questionnaires.questions', $questionnaire->id) }}"
                                    class="btn btn-primary position-absolute top-0 end-0 m-2">Go</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
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
