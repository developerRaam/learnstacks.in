@extends('frontend.common.base')

@push('setTitle') {{ app('settings')['site_name'] }} @endpush

@section('content')

    @include('frontend.common.carousel')

    <div class="container mt-5">
        <div class="row g-4 justify-content-center">
            @foreach ($posts as $post)
                <div class="col-md-4">
                    <div class="card custom-card">
                        @if (isset($post->featured_image))
                            <img src="{{ asset('storage/cache/posts') .'/'. pathinfo($post->featured_image, PATHINFO_FILENAME) . '_600.jpg' }}" class="card-img-top" alt="{{ $post->title }}">
                        @endif
                        <div class="card-body">
                            <p class="card-text">{{ $post->title }}</p>
                            <a href="{{ route('frontend.postShow', $post->slug) }}" class="btn btn-custom">Learn More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection