@extends('frontend.common.base')

@push('setTitle')
    {{ $category }}
@endpush

@section('content')

    <div class="container-fluid mt-2">

        <div class="w-100 py-5 category_image mb-2 rounded">
            <div class="position-absolute w-100 d-flex align-items-center justify-content-center h-100 rounded" style="z-index: 100;width: 100%;top:0;background-color:#000000ab"></div>
            <h2 class="text-center text-white fs-1 position-relative" style="z-index: 999;">{{ $category }}</h2>
        </div>

        <div class="row g-4 justify-content-start">
            @forelse ($posts as $post)
                <div class="col-md-6 col-lg-4 col-xl-4">
                    <div class="card custom-card h-100">
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
                <p class="text-center fs-4">Post Not Found</p>
            @endforelse
        </div>
    </div>

@endsection