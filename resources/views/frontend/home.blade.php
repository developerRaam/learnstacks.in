@extends('frontend.common.base')

@push('setTitle') Home @endpush

@section('content')

    @include('frontend.common.carousel')

    <div class="container-fluid mt-4">
        <div class="row g-4 justify-content-start">
            @foreach ($posts as $post)
                <div class="col-md-3">
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
            @endforeach
        </div>
    </div>

@endsection