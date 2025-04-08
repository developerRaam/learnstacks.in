@extends('frontend.common.base')

<!-- Meta Tags -->
@push('setTitle') {{$error->getStatusCode()}} {{$error->getMessage()}} @endpush

@section('content')

<div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 text-center px-4">
    <h1 class="text-7xl font-extrabold text-red-600">{{ $error->getStatusCode() }}</h1>
    <h2 class="text-2xl font-semibold text-gray-800 mt-2">Oops! {{ $error->getMessage() }}</h2>
    <p class="text-gray-500 mt-2">The page you are looking for does not exist or has been moved.</p>
    <a href="{{ url('/') }}" class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition">
      Go to Homepage
    </a>
  </div>
  
    
@endsection