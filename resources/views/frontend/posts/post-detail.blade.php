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

@push('addStyle')
    <style>
        .comment-box {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            /* box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); */
        }
        .comment {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .comment:last-child {
            border-bottom: none;
        }
        .comment span {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
        }
        .comment-text {
            font-size: 14px;
            text-align: justify;
        }
        .comment-time {
            font-size: 12px;
            color: #777;
        }
        .comment-input {
            resize: none;
        }
    </style>
@endpush

@section('content')

    <div class="container detail-page mt-3">
        <div class="row g-4">

            <div class="col-md-8">
                @if (isset($post->featured_image))
                    <img src="{{ asset('storage').'/'. $post->featured_image }}" alt="{{ $post->title }}" class="card-detail-img">
                @endif
                
                <h2 class="card-title">{{ $post->title }}</h2>

                <div class="p-2" style="text-align: justify;">
                    {!! $post->description !!}
                </div>
            </div>

            <!-- right-Sidebar Section -->
            <div class="col-md-4 mb-3">
                <div class="right-sidebar">
                    <h5>Related Articles</h5>
                    <ul class="list-unstyled">
                        @foreach ($posts as $item)
                            <li><a href="{{ route('frontend.postShow', $item->slug) }}">{{ $item->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Comment box -->
            <div class="container mt-1">
                <div class="comment-box">
                    <h5>Comments</h5>
                    
                    <!-- Existing Comments -->
                    <div class="comment-box">
                        <div id="comments-section">
                            <!-- Comments will be loaded here dynamically -->
                        </div>
                    </div>
            
                    <!-- Add a Comment -->
                    <div class="col-sm-6 ">
                        @include('frontend.common.alert')
                        <form action="{{ $action }}" method="post">
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            @csrf
                            <div class="card p-3">
                                <div class="mb-3">
                                    <label class="mb-1">Name</label>
                                    <input type="text" class="form-control comment-input" name="name" value="{{ old('name') }}" placeholder="Enter your good name ❤️">
                                    @error('name')
                                        <p class="mt-1 mb-0 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
        
                                <div class="mb-3">
                                    <label class="mb-1">Email</label>
                                    <input type="text" class="form-control comment-input" name="email" value="{{ old('email') }}" placeholder="abc@gmail.com">
                                    @error('email')
                                        <p class="mt-1 mb-0 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="mb-1">Add a comment:</label>
                                    <textarea class="form-control comment-input" rows="3" name="comment" placeholder="Write your comment...">{{ old('comment') }}</textarea>
                                    @error('comment')
                                        <p class="mt-1 mb-0 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Post Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
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
                        console.log(comment.name);
                        
                        const commentHtml = `
                            <div class="comment d-flex">
                                <span class="col-2"><i class="fa-solid fa-user"></i></span>
                                <div class="col-10 ms-3">
                                    <h6 class="mb-1">${comment.name} 
                                        <small class="comment-time">- ${formatTime(comment.created_at)}</small>
                                    </h6>
                                    <p class="comment-text">${comment.comment}</p>
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