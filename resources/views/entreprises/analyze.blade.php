@extends('layouts.app')

@section('content')
<div class="container">
    {{-- <h2>{{ $avis->count() }} Reviews</h2> --}}
    <h2>Suggestions for Improvement</h2>
    @if(!empty($suggestions))
        <h4>{!! $suggestions !!}</h4>
    @else
        <h4>No relevant suggestions.</h4>
    @endif

    <hr>

    <div class="reviews">
        @foreach($avis as $index => $avi)
            <h3>feedback #{{ $index + 1 }}</h3>
            <p>{{ $avi->commentaire }}</p>
        @endforeach
    </div>
</div>
@endsection
