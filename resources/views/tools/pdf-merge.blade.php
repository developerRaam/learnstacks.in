@extends('frontend.common.base')
@push('setTitle') PDF Merge @endpush

@push('addTitle'){{ 'PDF Merge' }}@endpush
@push('addDescription'){{ 'Compress images online without losing quality. Use our free Image Compressor to reduce JPG or PNG file size instantly. Fast, secure, and optimized for web.' }}@endpush
@push('addKeywords'){{'image compressor, compress image online, jpg compressor, png compressor, reduce image size, compress image without losing quality, image optimization tool, free image compressor, online image size reducer, fast image compression, Convert Image to PDF'}}@endpush
@push('addRobots'){{ 'index,follow' }}@endpush
@push('addGooglebot'){{ 'index,follow' }}@endpush

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl p-6">

            <div class="bg-slate-100 p-8 rounded-2xl border w-full max-w-xl mx-auto">
                <h2 class="text-3xl font-bold mb-6 text-gray-800 text-center">PDF Merge</h2>
            
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            
                <form method="POST" id="submitForm" action="{{ route('tools.pdfMerge') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <!-- Image Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Choose PDF</label>
                        <input type="file" name="pdfs[]" multiple class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" accept="application/pdf">
                    </div>
            
                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" id="submitBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-3 rounded-lg transition duration-200">
                            Convert
                        </button>
                    </div>
                </form>

                <!-- Result Display -->
                @if (session('path'))
                    <div class="mt-8 p-6 bg-green-50 border border-green-300 text-green-800 rounded-lg text-center">
                        <div class="flex grid-cols-3 justify-between items-center gap-5">
                            <iframe src="{{ session('path') }}#toolbar=0&navpanes=0&scrollbar=0" id="pdfPath" class="w-full h-[500px]" frameborder="0"></iframe>
                        </div>
                        <a href="{{ session('path') }}" class="inline-block mt-3 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition duration-200" download>
                            ⬇️ Download PDF
                        </a>
                    </div>
                @endif
            </div>
        
        </div>
    </div>
@endsection

@push('addScript')
    <script>
        document.getElementById('submitForm').addEventListener('submit', () => {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.textContent = 'Processing...';
            submitBtn.disabled = true;
        })
    </script>
@endpush