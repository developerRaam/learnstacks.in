@extends('frontend.common.base')
@push('setTitle') Home @endpush

@push('addTitle'){{ 'Home' }}@endpush
@push('addDescription'){{ app('settings')['site_description'] }}@endpush
@push('addKeywords'){{'tech blog, programming tutorials, web development tips, PHP tutorials, Laravel tutorials, coding best practices, tech job postings, AI tutorials, cybersecurity best practices'}}@endpush
@push('addRobots'){{ 'index,follow' }}@endpush
@push('addGooglebot'){{ 'index,follow' }}@endpush

@push('addOgTitle'){{ 'Home' }}@endpush
@push('addOgDescription'){{ app('settings')['site_description'] }}@endpush
@push('addOgImage'){{ asset('logo.jpg') }}@endpush
@push('addOgUrl'){{ route('frontend.home') }}@endpush
@push('addOgType'){{ 'article' }}@endpush
@push('addOgSiteName'){{ 'Learn Stacks' }}@endpush

@push('addCanonical'){{ route('frontend.home') }}@endpush
@push('addAuthor'){{ 'Learn Stacks' }}@endpush

@section('content')

    @include('frontend.common.carousel')

    <div class="w-full px-4 my-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          @foreach ($posts as $post)
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
          @endforeach
        </div>
    </div>

@endsection