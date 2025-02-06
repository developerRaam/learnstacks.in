@extends('frontend.common.base')

@push('addStyle')
<style>
    /* Custom Card Styling */
    .custom-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s;
    }

    .custom-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .custom-card img {
        height: 200px;
        object-fit: cover;
    }

    .custom-card .card-body {
        text-align: center;
    }

    .btn-custom {
        background-color: #007bff;
        color: white;
        border-radius: 20px;
        padding: 10px 20px;
        transition: background 0.3s ease-in-out;
    }

    .btn-custom:hover {
        background-color: #0056b3;
    }
</style>
@endpush

@section('content')

    @include('frontend.common.carousel')

    <div class="container mt-5">
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card custom-card">
                    <img src="{{ asset('banner.jpg') }}" class="card-img-top" alt="Card Image">
                    <div class="card-body">
                        <h5 class="card-title">Modern Tech Card</h5>
                        <p class="card-text">This is a modern card with Bootstrap 5, featuring hover effects and a smooth layout.</p>
                        <a href="#" class="btn btn-custom">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card custom-card">
                    <img src="{{ asset('banner.jpg') }}" class="card-img-top" alt="Card Image">
                    <div class="card-body">
                        <h5 class="card-title">Modern Tech Card</h5>
                        <p class="card-text">This is a modern card with Bootstrap 5, featuring hover effects and a smooth layout.</p>
                        <a href="#" class="btn btn-custom">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card custom-card">
                    <img src="{{ asset('banner.jpg') }}" class="card-img-top" alt="Card Image">
                    <div class="card-body">
                        <h5 class="card-title">Modern Tech Card</h5>
                        <p class="card-text">This is a modern card with Bootstrap 5, featuring hover effects and a smooth layout.</p>
                        <a href="#" class="btn btn-custom">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card custom-card">
                    <img src="{{ asset('banner.jpg') }}" class="card-img-top" alt="Card Image">
                    <div class="card-body">
                        <h5 class="card-title">Modern Tech Card</h5>
                        <p class="card-text">This is a modern card with Bootstrap 5, featuring hover effects and a smooth layout.</p>
                        <a href="#" class="btn btn-custom">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card custom-card">
                    <img src="{{ asset('banner.jpg') }}" class="card-img-top" alt="Card Image">
                    <div class="card-body">
                        <h5 class="card-title">Modern Tech Card</h5>
                        <p class="card-text">This is a modern card with Bootstrap 5, featuring hover effects and a smooth layout.</p>
                        <a href="#" class="btn btn-custom">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection