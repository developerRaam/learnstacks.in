@extends('admin.common.base')

@push('setTitle')
    {{$heading_title}}
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
                        <button class="btn btn-primary fs-4 px-3" data-bs-toggle="tooltip" id="submitButton" data-bs-placement="top" data-bs-title="Save"><i class="fa-solid fa-floppy-disk"></i></button>
                        <a class="btn btn-primary fs-4 px-3" href="{{ url()->previous() }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Back"><i class="fa-solid fa-reply"></i></a>
                    </div>
                </div>
            </div>
            <div class="row g-3 px-4">
                <div class="col-sm-12">
                    <!-- Alert Message -->
                    @include('admin.common.alert')

                    <div class="px-3 py-2 title-list">
                        <p class="mb-0"><i class="fa-solid fa-pencil"></i> {{ $list_title }}</p>
                    </div>
                    <div class="card rounded-0 p-3 mb-3 ">
                        <form action="{{$action}}" id="saveForm" method="post" enctype="multipart/form-data">
                            @csrf
                            @if (isset($user))
                                @method('PUT')  
                            @endif

                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="name">Name</label>
                                </div>
                                <div class="col-10">
                                    <input type="text" id="name" name="name" class="form-control p-2" value="{{ old('name', $user->name ?? '') }}" placeholder="Name">
                                    @error('name')
                                        <div class="errors">
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="username">Username</label>
                                </div>
                                <div class="col-10">
                                    <input type="text" id="username" name="username" class="form-control p-2" value="{{ old('username', $user->username ?? '') }}" placeholder="username">
                                    @error('username')
                                        <div class="errors">
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="email">Email</label>
                                </div>
                                <div class="col-10">
                                    <input type="text" id="email" name="email" class="form-control p-2" value="{{ old('email', $user->email ?? '') }}" placeholder="Email">
                                    @error('email')
                                        <div class="errors">
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="role">Role</label>
                                </div>
                                <div class="col-10">
                                    <select id="role" name="role" class="form-control p-2">
                                        <option value="">Select User</option>
                                        <option value="user" @if(isset($user) && $user->role == 'user') selected @endif>User</option>
                                        <option value="admin" @if(isset($user) && $user->role == 'admin') selected @endif>Admin</option>
                                    </select>
                                    @error('role')
                                        <div class="errors">
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="new_password">New Password</label>
                                </div>
                                <div class="col-10">
                                    <input type="text" id="new_password" name="new_password" class="form-control p-2" placeholder="New Password">
                                    @error('new_password')
                                        <div class="errors">
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="confirm_password">Confirm Password</label>
                                </div>
                                <div class="col-10">
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control p-2" placeholder="Confirm Password">
                                    @error('confirm_password')
                                        <div class="errors">
                                        <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section>
<script>

    // Form save 
    document.addEventListener("DOMContentLoaded", function() {
        let submitButton = document.getElementById("submitButton");
        let form = document.getElementById("saveForm");

        submitButton.addEventListener("click", function() {
            form.submit(); // This will submit the form when the button is clicked
        });
    });
</script>
@endsection