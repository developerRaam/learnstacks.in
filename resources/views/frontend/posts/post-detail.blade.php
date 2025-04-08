@extends('frontend.common.base')
@push('setTitle'){{ $post->title }}@endpush

@push('addTitle'){{ $post->title }}@endpush
@push('addDescription'){{ $post->short_description }}@endpush
@push('addKeywords'){{ $post->keywords }}@endpush
@push('addRobots'){{ $post->robots }}@endpush
@push('addGooglebot'){{ $post->googlebot }}@endpush

@push('addOgTitle'){{ $post->title }}@endpush
@push('addOgDescription'){{ $post->short_description }}@endpush
@push('addOgImage'){{ url('storage/'.$post->featured_image) }}@endpush
@push('addOgUrl'){{ route('frontend.postShow', $post->slug) }}@endpush
@push('addOgType'){{ 'article' }}@endpush
@push('addOgSiteName'){{ 'Learn Stacks' }}@endpush

@push('addCanonical'){{ route('frontend.postShow', $post->slug) }}@endpush
@push('addAuthor'){{ 'Learn Stacks' }}@endpush
@push('addCategory'){{ $post->category->name }}@endpush

@push('addArticlePublishDate'){{ $post->published_at }}@endpush
@push('addArticleModifiedData'){{ $post->updated_at }}@endpush
@push('addArticleSection'){{ 'Blog Post' }}@endpush
@push('addArticleTag'){{ $post->tags }}@endpush

@section('content')

<div class="max-w-7xl mx-auto px-4 my-8 grid grid-cols-1 md:grid-cols-3 gap-6 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
    <!-- Left Main Content -->
    <div class="md:col-span-2 space-y-4">
        @if (isset($post->featured_image))
            <img src="{{ asset('storage') . '/' . $post->featured_image }}" alt="{{ $post->title }}" class="w-full rounded-lg object-cover">
        @endif
  
        <h2 class="text-2xl font-bold text-gray-800">{{ $post->title }}</h2>
    
        <div class="text-gray-700 leading-relaxed text-justify">
            {!! $post->description !!}
        </div>
    </div>
  
    <!-- Right Sidebar -->
    <div class="space-y-4 animate__animated animate__fadeInDown" style="animation-delay: 0.2s;">
        <div class="bg-white shadow-md rounded-lg p-4">
            <h5 class="text-lg font-semibold mb-3">Related Articles</h5>
            <ul class="space-y-2">
                @foreach ($posts as $item)
                    <li>
                        <a href="{{ route('frontend.postShow', $item->slug) }}" class="text-indigo-600 hover:underline">
                            {{ $item->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
  
<!-- Comment Section -->
<div class="max-w-3xl lg:px-32">
    <div class="space-y-6">
        <h5 class="text-xl font-semibold">Comments</h5>
    
        <!-- Comment Form -->
        @include('frontend.common.alert')
        <form action="{{ $action }}" method="post">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <div class="bg-white rounded-lg shadow-md p-6 space-y-4">
            <div>
                <label class="block mb-1 font-medium">Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Enter your good name ❤️">
                @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
    
            <div>
                <label class="block mb-1 font-medium">Email</label>
                <input type="text" name="email" value="{{ old('email') }}"
                    class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="abc@gmail.com">
                @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
    
            <div>
                <label class="block mb-1 font-medium">Add a comment:</label>
                <textarea name="comment" rows="4"
                        class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Write your comment...">{{ old('comment') }}</textarea>
                @error('comment')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
    
            <button type="submit"
                    class="inline-block px-6 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition">
                Post Comment
            </button>
            </div>
        </form>

        <!-- Dynamic Comments -->
        <div id="comments-section" class="space-y-4">
            <!-- Comments will be loaded here dynamically -->
        </div>
    </div>
</div>

@endsection

@push('addScript')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Replace with your actual API endpoint  
        const route = {!! json_encode(route('frontend.getComment', $post->id)) !!};  

        // Fetch comments from API
        fetch(route)
            .then(response => response.json())
            .then(data => {
                const commentsContainer = document.getElementById("comments-section");
                commentsContainer.innerHTML = ""; // Clear existing comments

                data.comments.data.forEach(comment => {
                    
                    const commentHtml = `
                        <div class="flex items-start gap-4 py-4 border-b">
                            <div class="text-xl text-gray-600">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="flex-1">
                                <h6 class="text-sm font-semibold text-gray-800 mb-1">
                                    ${comment.name}
                                    <small class="text-xs text-gray-500 ml-2">- ${formatTime(comment.created_at)}</small>
                                </h6>
                                <p class="text-sm text-gray-700">${comment.comment}</p>
                            </div>
                        </div>
                    `;
                    commentsContainer.innerHTML += commentHtml;
                });
            })
            .catch(error => console.error("Error fetching comments:", error));

        // Format timestamp function
        function formatTime(timestamp) {
            const date = new Date(timestamp);
            return date.toLocaleString();
        }
    });
</script>


@endpush