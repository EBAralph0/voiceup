@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="d-flex mt-2" style="justify-content: space-between;">
        <div>Sectors</div>
        <!-- Add Button -->
        <button class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#addSecteurModal">Add</button>
    </h1>
    <input type="text" id="search" class="form-control mb-4" placeholder="Search...">
    <table id="secteurTable" class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($secteurs as $secteur)
                <tr>
                    <td>{{ $secteur->nom_secteur }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-primary btn-sm me-1" data-toggle="modal" data-target="#editSecteurModal-{{ $secteur->id_secteur }}"><i class="bi bi-pencil">Edit</i></button>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editSecteurModal-{{ $secteur->id_secteur }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('secteurs.update', $secteur->id_secteur) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Secteur</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="nom">Name</label>
                                                <input type="text" class="form-control" id="nom" name="nom_secteur" value="{{ $secteur->nom_secteur }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Button -->
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteSecteurModal-{{ $secteur->id_secteur }}"><i class="bi bi-trash-fill">Delete</i></button>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteSecteurModal-{{ $secteur->id_secteur }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('secteurs.destroy', $secteur->id_secteur) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Delete Secteur</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this secteur?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $secteurs->links('vendor.pagination.bootstrap-5') }} <!-- Pagination links -->
</div>

<!-- Add Modal -->
<div class="modal fade" id="addSecteurModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('secteurs.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Sector</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nom">Name</label>
                        <input type="text" class="form-control" id="nom" name="nom_secteur" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Add Sector</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    // Filtrer la table
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#secteurTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection
