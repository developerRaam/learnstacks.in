@extends('frontend.common.base')

@push('setTitle') Login @endpush

@section('content')

<section class="container py-5">

    @include('frontend.common.alert')

    <!-- Social Media Login Card -->
    <div class="flex justify-center mt-10">
        <div class="w-full max-w-md">
        <div class="bg-white shadow-lg rounded-xl p-6">
            <div class="text-center">
            <h5 class="text-xl font-semibold mb-4">Sign in with Google</h5>
    
            <!-- Google Login Button -->
            <a href="{{ route('frontend.googlelogin') }}"
                class="flex items-center justify-center w-full mb-3 py-2 border border-gray-300 rounded-xl hover:bg-gray-100 transition">
                <img src="{{ asset('frontend/icon/signin-with-google.png') }}"alt="Google Sign-In"class="h-8 mr-2">
                <span class="text-sm font-medium text-gray-700">Continue with Google</span>
            </a>
            </div>
        </div>
        </div>
    </div>
  
</section>

@endsection