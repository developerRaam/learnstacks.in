@extends('frontend.common.base')

<!-- Meta Tags -->
@push('setTitle') {{$error->getStatusCode()}} {{$error->getMessage()}} @endpush

@section('content')

<div class="d-flex flex-column align-items-center justify-content-center vh-100 bg-light text-center">
    <h1 class="display-1 text-danger fw-bold">{{$error->getStatusCode()}}</h1>
    <h2 class="text-dark">Oops! {{$error->getMessage()}}</h2>
    <p class="text-muted">The page you are looking for does not exist or has been moved.</p>
    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Go to Homepage</a>
</div>
    
@endsection