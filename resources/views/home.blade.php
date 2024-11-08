@extends('layouts.app')

@section('content')
<div class="container bg-white p-4">
    <div class="row mb-4">
        <div class="col text-center">
            <h2>Company Comparison by Sector</h2>
            <p>Compare companies based on average ratings within each sector.</p>
        </div>
    </div>

    @foreach ($secteurs as $secteur)
        <div class="row mb-5">
            <div class="col">
                <h3>{{ $secteur['nom_secteur'] }}</h3>
                @if ($secteur['entreprises']->isEmpty())
                    <p>No companies available in this sector.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Logo</th>
                                    <th>Company Name</th>
                                    <th>Average Rating</th>
                                    <th>Number of Reviews</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($secteur['entreprises'] as $entreprise)
                                    <tr>
                                        <td><img src="{{ $entreprise['logo'] }}" alt="Logo of {{ $entreprise['nom'] }}" class="rounded" style="width: 50px; height: 50px;"></td>
                                        <td>{{ $entreprise['nom'] }}</td>
                                        <td>{{ $entreprise['averageRating'] ?? 'N/A' }} / 5</td>
                                        <td>{{ $entreprise['avisCount'] }} review(s)</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
