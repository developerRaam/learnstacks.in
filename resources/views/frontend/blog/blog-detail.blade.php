@extends('frontend.common.base')

@push('addStyle')
    <style>
        /* Custom Styles for Detail Page */
        .detail-page {
            background-color: #f8f9fa;
            padding: 20px 5px;
        }

        .card-detail-img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 32px;
            font-weight: bold;
            color: #333;
            margin-top: 20px;
        }

        .card-description {
            font-size: 18px;
            color: #555;
            line-height: 1.8;
            margin-top: 20px;
        }

        .back-button {
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 20px;
            margin-top: 40px;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        .right-sidebar {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .right-sidebar h5 {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            text-transform: uppercase;
        }

        .right-sidebar ul {
            padding-left: 0;
        }

        .right-sidebar ul li {
            margin-bottom: 15px;
        }

        .right-sidebar ul li a {
            font-size: 16px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease, padding-left 0.3s ease;
        }

        .right-sidebar ul li a:hover {
            color: #0056b3;
            padding-left: 10px;
            font-weight: bold;
        }

        .right-sidebar ul li a:focus {
            color: #0056b3;
            text-decoration: underline;
        }
    </style>
@endpush

@section('content')
    <!-- Page Content -->
    <div class="container detail-page">
        <div class="row g-4">
            <!-- Main Content Column -->
            <div class="col-md-8">
                <!-- Image Section -->
                <img src="{{ asset('banner.jpg') }}" alt="Card Image" class="card-detail-img">
                
                <!-- Title Section -->
                <h2 class="card-title">Modern Technology Card</h2>

                <div style="text-align: justify;">
                    <!-- Description Section -->
                    <p class="card-description">
                        In this detailed view, you can explore more about the modern technologies that are shaping our world.
                        We explore various technologies, their implementations, and how they are revolutionizing the industry.
                        From AI to IoT and beyond, this card explores it all. Stay tuned for more updates on this subject!
                    </p>
                    <p class="card-description">
                        In this detailed view, you can explore more about the modern technologies that are shaping our world.
                        We explore various technologies, their implementations, and how they are revolutionizing the industry.
                        From AI to IoT and beyond, this card explores it all. Stay tuned for more updates on this subject!
                    </p>
                    <p class="card-description">
                        In this detailed view, you can explore more about the modern technologies that are shaping our world.
                        We explore various technologies, their implementations, and how they are revolutionizing the industry.
                        From AI to IoT and beyond, this card explores it all. Stay tuned for more updates on this subject!
                    </p>
                    <p class="card-description">
                        In this detailed view, you can explore more about the modern technologies that are shaping our world.
                        We explore various technologies, their implementations, and how they are revolutionizing the industry.
                        From AI to IoT and beyond, this card explores it all. Stay tuned for more updates on this subject!
                    </p>
                    <p class="card-description">
                        In this detailed view, you can explore more about the modern technologies that are shaping our world.
                        We explore various technologies, their implementations, and how they are revolutionizing the industry.
                        From AI to IoT and beyond, this card explores it all. Stay tuned for more updates on this subject!
                    </p>
                </div>
            </div>

            <!-- right-Sidebar Section -->
            <div class="col-md-4">
                <div class="right-sidebar">
                    <h5>Related Articles</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">AI and the Future of Work</a></li>
                        <li><a href="#">Blockchain for Beginners</a></li>
                        <li><a href="#">The Rise of 5G Technology</a></li>
                        <li><a href="#">Exploring the Internet of Things</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    
@endsection