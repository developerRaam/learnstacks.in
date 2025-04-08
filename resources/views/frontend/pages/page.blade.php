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

    <div class="max-w-5xl mx-auto px-4 my-6">
        <div class="space-y-4">
    
        <div>
            <h2 class="text-2xl md:text-3xl font-semibold text-center mb-4">{{ $page->name }}</h2>
    
            <div class="prose max-w-none text-justify p-2">
            {!! $page->description !!}
            </div>
        </div>
    
        </div>
    </div>  
    
@endsection