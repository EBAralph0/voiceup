@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Users</h2>
    <a href="{{ route('users.create') }}" class="btn btn-success mb-3">Add User</a>

    <!-- Barre de recherche -->
    <div class="mb-3">
        <input type="text" id="searchUser" class="form-control" placeholder="Search users..." onkeyup="searchUsers()">
    </div>

    <table id="user_table" class="table table-striped">
        <thead>
            <tr>
                <th>
                    <a class="text-dark" href="#" onclick="sortUsers('name')"><i class="bi bi-arrows-vertical">Name</i></a>
                </th>
                <th>
                    <a class="text-dark" href="#" onclick="sortUsers('email')"><i class="bi bi-arrows-vertical">Email</i></a>
                </th>
                <th>
                    <a class="text-dark" href="#" onclick="sortUsers('role')"><i class="bi bi-arrows-vertical">Role</i></a>
                </th>
                <th>
                    <a class="text-dark" href="#" onclick="sortUsers('statut')"><i class="bi bi-arrows-vertical">Status</i></a>
                </th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->statut == 'ok' ? 'Active' : 'Blocked' }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning me-1"><i class="bi bi-pencil">Edit</i></a>



                    @if($user->statut == 'ok')
                    <button class="btn btn-danger" data-toggle="modal" data-target="#blockModal-{{ $user->id }}"><i class="bi bi-ban">Block</i></button>
                    <!-- block Modal -->
                    <div class="modal fade" id="blockModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form action="{{ route('users.block', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Block user {{ $user->name }}</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to ban this user?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Block anyway</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($user->statut == 'ko')
                    <button class="btn btn-success" data-toggle="modal" data-target="#unblockModal-{{ $user->id }}"><i class="bi bi-key-fill">Unblock</i></button>
                    <!-- block Modal -->
                    <div class="modal fade" id="unblockModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form action="{{ route('users.unblock', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Unblock user {{ $user->name }}</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to unblock this user?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">unblock anyway</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links('vendor.pagination.bootstrap-5') }} <!-- Pagination links -->
</div>
@endsection

@section('scripts')
<script>
    function searchUsers() {
        const searchQuery = document.getElementById('searchUser').value.toLowerCase();
        window.location.href = `?search=${searchQuery}`;
    }

    function searchUsers() {
        const value = document.getElementById('searchUser').value.toLowerCase();
        const cards = document.querySelectorAll('#entrepriseContainer .card');

        $('#user_table tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
    }

    function sortUsers(sortBy) {
        const urlParams = new URLSearchParams(window.location.search);
        let sortOrder = urlParams.get('sort_order') === 'asc' ? 'desc' : 'asc';
        window.location.href = `?sort_by=${sortBy}&sort_order=${sortOrder}`;
    }
</script>
@endsection
