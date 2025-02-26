@extends('frontend.common.base')

@push('setTitle') Login @endpush

@section('content')

<section class="container py-5 d-flex justify-content-center align-items-center">

    @include('frontend.common.alert')

<!-- Social Media Login Card -->
<div class="card shadow-sm border-0 mx-auto mt-5" style="max-width: 400px; border-radius: 20px;">
    <div class="card-body text-center">
        <h5 class="card-title mb-4">Sign in with Google</h5>

        <!-- Google Login -->
        <a href="{{ route('frontend.googlelogin') }}" class="btn w-100 mb-3" style="border: 1px solid #ddd; border-radius: 12px;">
            <img src="{{ asset('frontend/icon/signin-with-google.png') }}" alt="Google Sign-In" style="height: 32px; margin-right: 8px;">
            Sign in with Google
        </a>
{{-- 
        <!-- Facebook Login -->
        <a href="" class="btn btn-primary w-100 mb-3" style="border-radius: 12px;">
            <i class="bi bi-facebook me-2"></i> Sign in with Facebook
        </a>

        <!-- Twitter Login -->
        <a href="" class="btn btn-info text-white w-100" style="border-radius: 12px;">
            <i class="bi bi-twitter-x me-2"></i> Sign in with Twitter
        </a> --}}
    </div>
</div>
</section>

@endsection