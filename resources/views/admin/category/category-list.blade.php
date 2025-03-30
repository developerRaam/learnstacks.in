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
        window.location.href = {!! json_encode(route('admin.category')) !!}
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
                        <form id="filter-form" action="{{ route('admin.category') }}" method="GET">
                            <div class="row g-3">
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="search" placeholder="Search.." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2 text-center">
                                    <input class="btn btn-outline-primary" type="submit" value="Filter">
                                    <button type="button" class="btn btn-outline-danger" id="clearFilter">Clear</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="px-3 py-2 title-list">
                        <p class="mb-0"><i class="fa-solid fa-list"></i> {{ $list_title }}</p>
                    </div>
                    <div class="card rounded-0 p-3">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Sory By</th>
                                    <th>Menu Top</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($category as $cat)
                                    <tr>
                                        <td>{{ $cat->name }}</td>
                                        <td>{{ $cat->sort_by }}</td>
                                        <td>
                                            @if ($cat->menu_top)
                                                <span class="text-success">Yes</span>
                                            @else
                                                <span class="text-danger">No</span>
                                            @endif
                                        </td>                                        
                                        <td>
                                            @if ($cat->status)
                                                <span class="text-success">Enabled</span>
                                            @else
                                                <span class="text-danger">Disabled</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a class="btn btn-primary me-2" href="{{ route('admin.category.edit', $cat->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i></a>
                                                <form action="{{ route('admin.category.destroy', $cat->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger deleteRow" data-name="{{ $cat->name }}" data-row-name="Category" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>                                       
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <caption class="text-center">No category found.</caption>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $category->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection