<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css" integrity="sha384-BY+fdrpOd3gfeRvTSMT+VUZmA728cfF9Z2G42xpaRkUGu2i3DyzpTURDo5A6CaLK" crossorigin="anonymous"> --}}

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!--Style-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/custom.css') }}" rel="stylesheet"> --}}
    <style>
        .divider:after,
.divider:before {
    content: "";
    flex: 1;
    height: 1px;
    background: #eee;
}
.h-custom {
height: calc(100% - 73px);
}
@media (max-width: 450px) {
.h-custom {
height: 100%;
}
}
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm p-1">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/voiceup.png') }}" class="d-block" height="50px" width="50px" alt="Voice Up">
            </a>
            <form class="d-flex position-relative">
                <input id="searchInput" class="form-control me-2" type="search" placeholder="Search companies..." aria-label="Search">
                <button class="btn btn-outline-success" type="button">Search</button>
                <div id="searchResults" class="position-absolute container rounded bg-white shadow-sm" style="display: none; max-height: 300px; overflow-y: auto; width: 100%; z-index: 1000; top:3em;"></div>
            </form>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto"></ul>
                <ul class="navbar-nav ms-auto">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('demandes.create') }}">Add my company</a>
                                <a class="dropdown-item" href="{{ route('entreprises.index') }}">Company list</a>
                                <a class="dropdown-item" href="#">Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>
        @auth
            @if (Auth::user()->role === 'admin')
                <div id="sidebar">
                    @include('partials.sidebar')
                </div>
            @endif
        @endauth
        <div id="content" @auth @if (Auth::user()->role === 'admin')style="margin-left: 250px;" @endif @endauth  style="background-color: white">
            <main>
                @yield('content')
            </main>
        </div>
    </div>

    @section('scripts')
    <script defer>
        document.addEventListener('DOMContentLoaded', function() {
            var searchInput = document.getElementById('searchInput');
            var searchResults = document.getElementById('searchResults');

            searchInput.addEventListener('input', function() {
                var query = searchInput.value.trim();

                if (query.length > 0) {
                    // Envoyer une requête AJAX pour récupérer les résultats
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', `/search-companies?q=${encodeURIComponent(query)}`, true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var companies = JSON.parse(xhr.responseText);
                            displayResults(companies);
                        }
                    };
                    xhr.send();
                } else {
                    searchResults.style.display = 'none';
                }
            });

            function displayResults(companies) {
                searchResults.innerHTML = '';
                if (companies.length > 0) {
                    companies.forEach(function(company) {
                        var resultItem = document.createElement('a');
                        resultItem.href = `/entreprises/${company.id_entreprise}/list_questionnaire`;
                        resultItem.className = 'list-group-item list-group-item-action';
                        resultItem.innerHTML = `
                            <div class="d-flex align-items-center">
                                <img src="${company.logo_entreprise || '/images/voiceup.png'}" class="me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                <div>
                                    <strong>${company.nom_entreprise}</strong><br>
                                    <small>${company.slogan}</small>
                                </div>
                            </div>
                        `;
                        searchResults.appendChild(resultItem);
                    });
                    searchResults.style.display = 'block';
                } else {
                    searchResults.innerHTML = '<div class="list-group-item">No companies found</div>';
                    searchResults.style.display = 'block';
                }
            }

            // Masquer les résultats si l'utilisateur clique en dehors du champ de recherche
            document.addEventListener('click', function(event) {
                if (!searchResults.contains(event.target) && event.target !== searchInput) {
                    searchResults.style.display = 'none';
                }
            });
        });
    </script>
    @endsection

    @yield('scripts')
    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7HUbX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}

</body>
</html>
