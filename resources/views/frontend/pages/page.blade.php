@extends('frontend.common.base')

<!-- Meta Tags -->
@push('setTitle'){{ $page->name }}@endpush

@push('addTitle'){{ $page->name }}@endpush
@push('addDescription'){{ Str::words(strip_tags($page->description), 30) }}@endpush
@push('addKeywords'){{ $page->keywords }}@endpush
@push('addRobots'){{ $page->robots }}@endpush
@push('addGooglebot'){{ $page->googlebot }}@endpush

@push('addOgTitle'){{ $page->name }}@endpush
@push('addOgDescription'){{ Str::words(strip_tags($page->description), 30) }}@endpush
@push('addOgUrl'){{ route('frontend.page', $page->slug) }}@endpush
@push('addOgType'){{ 'about us' }}@endpush
@push('addOgSiteName'){{ 'Online Notes' }}@endpush

@push('addCanonical'){{ route('frontend.page', $page->slug) }}@endpush
@push('addAuthor'){{ 'Online Notes' }}@endpush

@section('content')

    <div class="container detail-page">
        <div class="row g-4">

            <div class="col-md-12">
                
                <h2 class="card-title text-center mb-3">{{ $page->name }}</h2>

                <div class="p-2" style="text-align: justify;">
                    {!! $page->description !!}
                </div>
            </div>

        </div>
    </div>
    
@endsection