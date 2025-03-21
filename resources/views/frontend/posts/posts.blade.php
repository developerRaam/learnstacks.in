@extends('frontend.common.base')

@push('setTitle'){{ $category?->name }}@endpush

@push('addTitle'){{ $category?->name}}@endpush
@push('addDescription'){{ $category?->description }}@endpush
@push('addKeywords'){{ $category?->keywords }}@endpush
@push('addRobots'){{ 'index,follow' }}@endpush
@push('addGooglebot'){{ 'index,follow' }}@endpush

@push('addOgTitle'){{ $category?->name }}@endpush
@push('addOgDescription'){{ $category?->description }}@endpush
@push('addOgUrl'){{ route('frontend.post', $category?->slug) }}@endpush
@push('addOgImage'){{ isset($category?->image) ? url('storage/'.$category?->image) : '' }}@endpush
@push('addOgType'){{ 'article' }}@endpush
@push('addOgSiteName'){{ 'Learn Stacks' }}@endpush

@push('addCanonical'){{ route('frontend.post', $category?->slug) }}@endpush
@push('addAuthor'){{ 'Learn Stacks' }}@endpush

@section('content')

    <div class="container-fluid my-2">

        <div class="w-100 py-5 category_image mb-2 rounded animate__animated animate__fadeInDown" style="animation-delay: 0.2s;">
            <div class="position-absolute w-100 d-flex align-items-center justify-content-center h-100 rounded" style="z-index: 100;width: 100%;top:0;background-color:#000000ab"></div>
            <h2 class="text-center text-white fs-1 position-relative" style="z-index: 999;">{{ $category?->name }}</h2>
        </div>

        <div class="row g-4 justify-content-start">
            @forelse ($posts as $post)
                <div class="col-md-6 col-lg-4 col-xl-3">
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
            @empty
                <p class="text-center fs-4 text-white">Post Not Found</p>
            @endforelse
        </div>
    </div>

@endsection