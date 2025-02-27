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
        window.location.href = {!! json_encode(route('admin.user')) !!}
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

    
    // Show user details
    document.addEventListener('DOMContentLoaded', function () {
        const userModal = document.getElementById('userModal');
        userModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-id');
            let route = {!! json_encode(route('admin.user')) !!} + '/' + userId 

            const modalBody = document.getElementById('modal-user-details');
            modalBody.innerHTML = '<p>Loading...</p>';
        
            fetch(route)
                .then(response => response.json())
                .then(data => {
                    // const avatarUrl = (data?.avatar) ? {!! json_encode(asset('storage')) !!} + '/' + data.avatar : {!! json_encode(asset('not-image-available.png')) !!};
                    modalBody.innerHTML = `
                    <div class="col-md-12">
                        <div class="card p-4 shadow rounded bg-white">
                            <div class="row g-3">
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <img src="${data?.avatar}" alt="Avatar" class="avatar rounded-circle me-3 p-2 border" style="width: 100%; aspect-ratio: 9 / 9; object-fit: cover;">
                                        <div class="mt-3">
                                            <h5 class="mb-1">${data.name}</h5>
                                            <p class="text-muted mb-0">${data.email}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <p><strong class="d-inline-block" style="width:170px">State:</strong> ${data.state ?? 'N/A'}</p>
                                    <p><strong class="d-inline-block" style="width:170px">Phone:</strong> ${data.phone ?? 'N/A'}</p>
                                    <p><strong class="d-inline-block" style="width:170px">Role:</strong> ${data.role ?? 'N/A'}</p>
                                </div>    
                            </div>
                        </div>
                    </div>

                    `;
                })
                .catch(error => {
                    modalBody.innerHTML = '<p>Error loading user details.</p>';
                    console.error('Error fetching user details:', error);
                });
        });
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
                </div>
            </div>

            
            <div class="row g-3 px-4">
                
                <div class="col-sm-12">
                    <!-- FIlter -->
                    <div class="card rounded-0 p-3 mb-3">
                        <form id="filter-form" action="{{ route('admin.user') }}" method="GET">
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>{{ $user->status }}</td>
                                        <td class="d-flex gap-2">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal" data-id="{{ $user->id }}">
                                                <i class="fa-solid fa-eye" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                        <caption class="text-center">No users found.</caption>
                                    @endforelse
                                </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $users->links('pagination::bootstrap-5') }}
                        </div>

                    </div>

                    <!-- User Detail Modal -->
                    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
                        <div class="modal-dialog" style="max-width: 900px">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="userModalLabel"><i class="fa-solid fa-user"></i> User Details</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="modal-user-details">
                                ...
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

</section>
@endsection