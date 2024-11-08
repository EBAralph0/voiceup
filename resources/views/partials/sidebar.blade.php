@auth
@if (Auth::user()->role === 'admin')
<div class="bg-dark h-100 ps-2" id="sidebar-wrapper">


    <div class="list-group list-group-flush">
        <a href="{{ route('secteurs.index') }}"
           class="list-group-item list-group-item-action bg-dark text-light {{ Request::routeIs('secteurs.index') ? 'active text-white' : '' }}">
            Sectors
        </a>
        <a href="{{ route('entreprises.index') }}"
           class="list-group-item list-group-item-action bg-dark text-light {{ Request::routeIs('entreprises.index') ? 'active text-white' : '' }}">
            Companies
        </a>
        <a href="{{ route('users.index') }}"
           class="list-group-item list-group-item-action bg-dark text-light {{ Request::routeIs('users.index') ? 'active text-white' : '' }}">
            Users
        </a>
        <a href="{{ route('demandes.index') }}"
           class="list-group-item list-group-item-action bg-dark text-light {{ Request::routeIs('demandes.index') ? 'active text-white' : '' }}">
            Requests
        </a>
    </div>
</div>
@endif
@endauth
