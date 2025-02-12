@extends('admin.common.base')

@push('setTitle')
    {{$heading_title}}
@endpush

@push('addStyle')

@endpush

@push('addScript')
<script>
    //================ clear filter button ===================
    document.getElementById('clearFilter').addEventListener('click', () => {
        window.location.href = {!! json_encode(route('admin.posts')) !!}
    })

    // JavaScript to handle form submission
    document.getElementById('filter-form').addEventListener('submit', function(event) {
        event.preventDefault();

        // Collect form data
        const form = event.target;
        const formData = new FormData(form);

        const queryParams = [];
        formData.forEach((value, key) => {
            if (value.trim() !== '') { // Check if value is not empty or only whitespace
                queryParams.push(`${key}=${encodeURIComponent(value)}`);
            }
        });

        // Construct URL with query parameters
        const actionUrl = form.getAttribute('action');
        const urlWithParams = actionUrl + '?' + queryParams.join('&');

        // Redirect to the constructed URL
        window.location.href = urlWithParams;
    });

</script>

@endpush

@section('content')
<section class="container-fluid px-0">
    <div class="row">
        <div class="col-sm-2 p-0">
            @include('admin.common.left-sidebar')
        </div>
        <div class="col-sm-10 p-0">
            <div class="m-4">
                <div class="admin-title d-flex justify-content-between px-2">
                    <div class="d-flex admin-title-box">
                        <h2>{{$heading_title}}</h2>
                        <div class="breadcrumbs">
                            <ul class="ms-3">
                                @foreach ($breadcrumbs as $breadcrumb)
                                    <li>
                                        @if ($breadcrumb['href'])
                                            <a href="{{$breadcrumb['href']}}">{{$breadcrumb['text']}}</a>
                                        @else
                                            <span class="text-muted">{{$breadcrumb['text']}}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div>
                        <a class="btn btn-primary fs-4 px-3" href="{{$add}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add {{$heading_title}}"><i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
            </div>

            
            <div class="row g-3 px-4">
                
                <div class="col-sm-12">
                    <!-- FIlter -->
                    <div class="card rounded-0 p-3 mb-3">
                        <form id="filter-form" action="{{ route('admin.posts') }}" method="GET">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input class="form-control" type="text" name="search" placeholder="Search.." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" type="date" name="start_date" value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" type="date" name="end_date" value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-2 text-center">
                                    <input class="btn btn-outline-primary" type="submit" value="Filter">
                                    <button type="button" class="btn btn-outline-danger" id="clearFilter">Clear</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Alert Message -->
                    @include('admin.common.alert')

                    <div class="px-3 py-2 title-list">
                        <p class="mb-0"><i class="fa-solid fa-list"></i> {{ $list_title }}</p>
                    </div>
                    <div class="card rounded-0 p-3">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Publish Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($posts as $post)
                                    <tr>
                                        <td>
                                            <img height="50" src="{{ $post->featured_image ? asset('storage').'/'.$post->featured_image : asset('not-image-available.png')}}">
                                        </td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->status }}</td>
                                        <td>{{ $post->published_at?->format('d-m-Y h:i A') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a class="btn btn-primary me-2" href="{{ route('admin.posts.edit', $post->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i></a>
                                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger deleteRow" data-name="{{ $post->title }}" data-row-name="Post" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>                                       
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                        <caption class="text-center">No users found.</caption>
                                    @endforelse
                                </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $posts->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                    
                </div>
            </div>
        </div>
    </div>

</section>
@endsection