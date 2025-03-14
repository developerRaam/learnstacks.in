@extends('frontend.common.base')
@push('setTitle') Home @endpush

@push('addTitle'){{ 'Home' }}@endpush
@push('addDescription'){{ app('settings')['site_description'] }}@endpush
@push('addKeywords'){{'tech blog, programming tutorials, web development tips, PHP tutorials, Laravel tutorials, coding best practices, tech job postings, AI tutorials, cybersecurity best practices'}}@endpush
@push('addRobots'){{ 'index,follow' }}@endpush
@push('addGooglebot'){{ 'index,follow' }}@endpush

@push('addOgTitle'){{ 'Home' }}@endpush
@push('addOgDescription'){{ app('settings')['site_description'] }}@endpush
@push('addOgImage'){{ asset('logo.jpg') }}@endpush
@push('addOgUrl'){{ route('frontend.home') }}@endpush
@push('addOgType'){{ 'article' }}@endpush
@push('addOgSiteName'){{ 'Learn Stacks' }}@endpush

@push('addCanonical'){{ route('frontend.home') }}@endpush
@push('addAuthor'){{ 'Learn Stacks' }}@endpush

@section('content')

    @include('frontend.common.carousel')

    <div class="container my-4">
        <div class="row g-4 justify-content-start">
            @foreach ($posts as $post)
                <div class="col-md-6 col-lg-4 col-xl-4">
                    <div class="card custom-card h-100 animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->index * 0.2 }}s;">
                        @if (isset($post->featured_image))
                            <img src="{{ asset('storage/cache/posts') .'/'. pathinfo($post->featured_image, PATHINFO_FILENAME) . '_600.jpg' }}" class="card-img-top" alt="{{ $post->title }}">
                        @endif
                        <div class="card-body">
                            <p class="card-title fs-5 text-start">{{ $post->title }}</p>
                            <p class="card-text text-start">{{ substr($post->short_description, 0, 100) }}...</p>
                            <a href="{{ route('frontend.postShow', $post->slug) }}" class="btn btn-custom">Learn More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection