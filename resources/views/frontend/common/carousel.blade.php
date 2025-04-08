<div id="default-carousel" class="relative w-full" data-carousel="slide">
    {{-- <div id="carousel-autoplay" class="relative w-full" data-carousel="slide" data-carousel-interval="3000"> --}}
    <!-- Carousel wrapper -->
    <div class="relative h-[450px] overflow-hidden">
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            @foreach ($banners as $index => $banner)
            <div class="w-full flex-shrink-0 relative">
                <img class="w-full h-[500px] object-cover" src="{{ asset('storage') . '/' . $banner->image }}" alt="{{ $banner->title }}">
                <div class="absolute inset-0 flex items-center justify-center bg-black/50 z-10">
                    <div class="max-w-3xl p-4 text-center">
                        @if (!empty($banner->title))
                            <h1 class="text-white text-4xl md:text-5xl font-bold">{{ $banner->title }}</h1>
                        @endif
                        @if (!empty($banner->description))
                            <p class="text-white text-lg mt-4">{{ $banner->description }}</p>
                        @endif
                        @if (!empty($banner->button_text))
                            <div class="mt-6">
                                <a href="{{ $banner->button_url }}" class="px-6 py-3 rounded shadow inline-block transition duration-300 no-underline"
                                   style="background-color: {{ $banner->button_background }}; color: {{ $banner->button_color }}; border: 1px solid {{ $banner->border_color }};">
                                   {{ $banner->button_text }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
  
    <!-- Slider controls -->
    <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
      <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60">
        <svg aria-hidden="true" class="w-6 h-6 text-white dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span class="sr-only">Previous</span>
      </span>
    </button>
    <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
      <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60">
        <svg aria-hidden="true" class="w-6 h-6 text-white dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="sr-only">Next</span>
      </span>
    </button>
  </div>
  
