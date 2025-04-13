@extends('frontend.common.base')
@push('setTitle') Tools @endpush

@push('addTitle'){{ 'Tools' }}@endpush
@push('addDescription'){{ 'Compress images online without losing quality. Use our free Image Compressor to reduce JPG or PNG file size instantly. Fast, secure, and optimized for web.' }}@endpush
@push('addKeywords'){{'image compressor, compress image online, jpg compressor, png compressor, reduce image size, compress image without losing quality, image optimization tool, free image compressor, online image size reducer, fast image compression'}}@endpush
@push('addRobots'){{ 'index,follow' }}@endpush
@push('addGooglebot'){{ 'index,follow' }}@endpush

@section('content')
    <div class="bg-slate-300">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="w-full px-4 my-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 justify-center">
                    <a href="{{ route('tools.imageCompress') }}">
                        <div class="max-w-sm rounded-2xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-xl transition-shadow duration-300">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Image Compress</h3>
                        </div>
                    </a>
    
                    <a href="{{ route('tools.convertJpgToPng') }}">
                        <div class="max-w-sm rounded-2xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-xl transition-shadow duration-300">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Convert JPG to PNG</h3>
                        </div>
                    </a>
    
                    <a href="{{ route('tools.convertPngToJpg') }}">
                        <div class="max-w-sm rounded-2xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-xl transition-shadow duration-300">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Convert PNG to JPG</h3>
                        </div>
                    </a>

                    <a href="{{ route('tools.convertImageToPdf') }}">
                        <div class="max-w-sm rounded-2xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-xl transition-shadow duration-300">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Convert Image to PDF</h3>
                        </div>
                    </a>
    
                </div>
            </div>
        </div>
    </div>
@endsection