@extends('frontend.common.base')
@push('setTitle') Image compressor @endpush

@push('addTitle'){{ 'Image compressor' }}@endpush
@push('addDescription'){{ 'Compress images online without losing quality. Use our free Image Compressor to reduce JPG or PNG file size instantly. Fast, secure, and optimized for web.' }}@endpush
@push('addKeywords'){{'image compressor, compress image online, jpg compressor, png compressor, reduce image size, compress image without losing quality, image optimization tool, free image compressor, online image size reducer, fast image compression'}}@endpush
@push('addRobots'){{ 'index,follow' }}@endpush
@push('addGooglebot'){{ 'index,follow' }}@endpush

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl p-6">

            <div class="bg-slate-100 p-8 rounded-2xl border w-full max-w-xl mx-auto">
                <h2 class="text-3xl font-bold mb-6 text-gray-800 text-center">Upload & Compress Image</h2>
            
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            
                <form method="POST" id="submitForm" action="{{ route('tools.imageCompress') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
            
                    <!-- Image Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Choose Image</label>
                        <input type="file" name="image" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" accept="image/jpeg,png">
                    </div>
            
                    <!-- Quality Slider -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Compression Quality</label>
                        <div class="text-center text-indigo-600 font-semibold mb-2" id="sliderValue">Value: 50</div>
                        <input id="slider" type="range" name="quality" min="10" max="100" value="50" class="w-full cursor-pointer appearance-none bg-gray-200 h-2 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
            
                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" id="submitBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-3 rounded-lg transition duration-200">
                            Compress
                        </button>
                    </div>
                </form>
            
                <!-- Result Display -->
                @if (session('path') && session('size_kb'))
                    <div class="mt-8 p-6 bg-green-50 border border-green-300 text-green-800 rounded-lg">
                        <img src="{{ session('path') }}" alt="Compressed Image" class="w-32 h-auto rounded shadow mb-3">
                        <p><strong>Size:</strong> {{ session('size_kb') }}</p>
                        <a href="{{ session('path') }}" class="inline-block mt-3 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition duration-200" download>
                            ⬇️ Download Image
                        </a>
                    </div>
                @endif
            </div>
        
        </div>
    </div>
@endsection

@push('addStyle')
    <style>
        input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        height: 1.25rem;
        width: 1.25rem;
        background-color: #6366f1; /* indigo-500 */
        border-radius: 9999px;
        cursor: pointer;
        border: 2px solid white;
        box-shadow: 0 0 2px rgba(0, 0, 0, 0.2);
        margin-top: -6px; /* align thumb with track */
        }

        input[type="range"]::-moz-range-thumb {
        height: 1.25rem;
        width: 1.25rem;
        background-color: #6366f1;
        border-radius: 9999px;
        cursor: pointer;
        border: 2px solid white;
        }

        input[type="range"]::-webkit-slider-runnable-track {
        height: 0.5rem;
        background-color: #e5e7eb; /* gray-200 */
        border-radius: 9999px;
        }

        input[type="range"]::-moz-range-track {
        height: 0.5rem;
        background-color: #e5e7eb;
        border-radius: 9999px;
        }
    </style>
@endpush

@push('addScript')
    <script>
        const slider = document.getElementById("slider");
        const output = document.getElementById("sliderValue");
        slider.addEventListener("input", () => {
            output.textContent = `Value: ${slider.value}`;
        });
    </script>
    <script>
        document.getElementById('submitForm').addEventListener('submit', () => {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.textContent = 'Processing...';
            submitBtn.disabled = true;
        })
    </script>
@endpush