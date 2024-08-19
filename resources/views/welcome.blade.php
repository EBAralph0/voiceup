@extends('layouts.app')

@section('content')

<div id="myCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2" class=""></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3" class="active" aria-current="true"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item">
          {{-- <img src="{{ asset("images/e1.jpg") }}" class="bd-placeholder-img" alt="..." aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false" width="100%" height="100%" style="background-size: cover;background-position: center;background-repeat: no-repeat;"> --}}
          <img src="{{ asset("images/e1.jpg") }}" height="450px" class="d-block w-100" alt="..." style="background-size: cover;background-position: center;background-repeat: no-repeat;">
          <div class="container">
            <div class="carousel-caption text-start shadow" style="background-color: #27272761;padding-inline: 5px;">
              <h1>Example headline.</h1>
              <p>Some representative placeholder content for the first slide of the carousel.</p>
              <p><a class="btn btn-lg btn-primary" href="#">Sign up today</a></p>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          {{-- <img src="{{ asset("images/e2.jpg") }}" class="bd-placeholder-img" alt="..." aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"> --}}
          <img src="{{ asset("images/e2.jpg") }}" class="d-block w-100" height="450px" alt="..." style="background-size: cover;background-position: center;background-repeat: no-repeat;">
          <div class="container">
            <div class="carousel-caption" style="background-color: #27272761;padding-inline: 5px;">
              <h1>Another example headline.</h1>
              <p>Some representative placeholder content for the second slide of the carousel.</p>
              <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
            </div>
          </div>
        </div>
        <div class="carousel-item active">
          {{-- <img src="{{ asset("images/e3.jpg") }}" class="bd-placeholder-img" alt="..." aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"> --}}
          <img src="{{ asset("images/e3.jpg") }}" class="d-block w-100" height="450px" alt="..." style="background-size: cover;background-position: center;background-repeat: no-repeat;">
          <div class="container">
            <div class="carousel-caption text-end" style="background-color: #27272761;padding-inline: 5px;">
              <h1>One more for good measure.</h1>
              <p>Some representative placeholder content for the third slide of this carousel.</p>
              <p><a class="btn btn-lg btn-primary" href="#">Browse gallery</a></p>
            </div>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
</div>



    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="row flex-nowrap overflow-auto" >
        {{-- <div class="col-lg-4">
          <img src="{{ asset("images/e3.jpg") }}" class="bd-placeholder-img" width="130px" height="130px" alt="..." style="background-size: cover;background-repeat: no-repeat;">

          <h2>Heading</h2>
          <p>Some representative placeholder content for the three columns of text below the carousel. This is the first column.</p>
          <p><a class="btn btn-secondary" href="#">View details »</a></p>
        </div><!-- /.col-lg-4 --> --}}


        <div id="entreprisesCarousel" class="carousel carousel-dark slide" data-ride="carousel" >
            <div class="carousel-inner">
                @foreach($entreprises->chunk(3) as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="d-flex justify-content-center">
                            @foreach($chunk as $e)
                                <div class="card mx-2" style="min-width: 18rem; max-width: 18rem;">
                                    <img src="{{ $e->logo_entreprise }}" class="card-img-top" alt="{{ $e->nom_entreprise }}" style="height: 130px; object-fit: cover;">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-truncate" style="max-height: 2.4em; line-height: 1.2em; overflow: hidden;">
                                            {{ $e->sigle }} : {{ $e->nom_entreprise }}
                                        </h5>
                                        <p class="card-text flex-grow-1 text-truncate" style="max-height: 4.8em; line-height: 1.2em; overflow: hidden;">
                                            {{ $e->description }}
                                        </p>
                                        <a href="{{ route('entreprises.list_questionnaire', $e->id_entreprise) }}" class="btn btn-secondary mt-auto">Voir les détails »</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#entreprisesCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#entreprisesCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
        </div>


      </div><!-- /.row -->


      <!-- START THE FEATURETTES -->

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">First featurette heading. <span class="text-muted">It’ll blow your mind.</span></h2>
          <p class="lead">Some great placeholder content for the first featurette here. Imagine some exciting prose here.</p>
        </div>
        <div class="col-md-5">
          <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"></rect><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>

        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7 order-md-2">
          <h2 class="featurette-heading">Oh yeah, it’s that good. <span class="text-muted">See for yourself.</span></h2>
          <p class="lead">Another featurette? Of course. More placeholder content here to give you an idea of how this layout would work with some actual real-world content in place.</p>
        </div>
        <div class="col-md-5 order-md-1">
          <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"></rect><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>

        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">And lastly, this one. <span class="text-muted">Checkmate.</span></h2>
          <p class="lead">And yes, this is the last block of representative placeholder content. Again, not really intended to be actually read, simply here to give you a better view of what this would look like with some actual content. Your content.</p>
        </div>
        <div class="col-md-5">
          <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"></rect><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>

        </div>
      </div>

      <hr class="featurette-divider">

      <!-- /END THE FEATURETTES -->

    </div><!-- /.container -->


    <!-- FOOTER -->
    <footer class="container">
      <p class="float-end"><a href="#">Back to top</a></p>
      <p>© 2017–2021 Company, Inc. · <a href="#">Privacy</a> · <a href="#">Terms</a></p>
    </footer>


@endsection

