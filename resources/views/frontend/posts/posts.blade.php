@extends('frontend.common.base')

@push('setTitle'){{ $category?->name }}@endpush

@push('addTitle'){{ $category?->name}}@endpush
@push('addDescription'){{ $category?->description }}@endpush
@push('addKeywords'){{ $category?->keywords }}@endpush
@push('addRobots'){{ 'index,follow' }}@endpush
@push('addGooglebot'){{ 'index,follow' }}@endpush

@push('addOgTitle'){{ $category?->name }}@endpush
@push('addOgDescription'){{ $category?->description }}@endpush
@push('addOgUrl'){{ route('frontend.post', $category?->slug) }}@endpush
@push('addOgImage'){{ isset($category?->image) ? url('storage/'.$category?->image) : '' }}@endpush
@push('addOgType'){{ 'article' }}@endpush
@push('addOgSiteName'){{ 'Learn Stacks' }}@endpush

@push('addCanonical'){{ route('frontend.post', $category?->slug) }}@endpush
@push('addAuthor'){{ 'Learn Stacks' }}@endpush

@section('content')

    <div class="w-full mt-2">

        {{-- <div class="w-full py-12 mb-4 relative overflow-hidden rounded-lg bg-cover bg-center category_image animate__animated animate__fadeInDown"
            style="animation-delay: 0.2s; background-image: url('path/to/your/background.jpg');">
        
            <!-- Overlay -->
            <div class="absolute inset-0 bg-slate-400 z-10 rounded-lg"></div>

            <!-- Heading -->
            <h2 class="relative z-20 text-center text-white text-4xl font-bold">
                {{ $category?->name }}
            </h2>
        </div> --}}


        <div class="w-full px-4 my-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($posts as $post)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300" style="animation-delay: {{ $loop->index * 0.2 }}s;">
                    @if (isset($post->featured_image))
                        <img src="{{ asset('storage/cache/posts') . '/' . pathinfo($post->featured_image, PATHINFO_FILENAME) . '_600.jpg' }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                    @endif
          
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $post->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 text-start">{{ \Illuminate\Support\Str::limit($post->short_description, 100) }}</p>
                        <a href="{{ route('frontend.postShow', $post->slug) }}" class="inline-block px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition">
                        Learn More
                        </a>
                    </div>
                </div>
                @empty
                    <p class="text-center fs-4 text-white">Post Not Found</p>
                @endforelse
            </div>
        </div>
    </div>

@endsection