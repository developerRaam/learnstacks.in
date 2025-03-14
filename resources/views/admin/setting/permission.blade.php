@extends('admin.common.base')

@push('setTitle')
    {{$heading_title}}
@endpush

@push('addScript')
    <script>
        // Form save 
        document.addEventListener("DOMContentLoaded", function() {
            let submitButton = document.getElementById("submitButton");
            let form = document.getElementById("saveForm");

            submitButton.addEventListener("click", function() {
                form.submit(); // This will submit the form when the button is clicked
            });
        });

        const userId = document.getElementById('user_id')
        if(userId){
            userId.addEventListener('click', () => {
                // Select all checkboxes and uncheck them
                document.querySelectorAll('input[type="checkbox"]').forEach(input => {
                    input.checked = false;
                });
                
                if(userId.value.trim() !== ''){
                    // Send to PHP using fetch
                    fetch(`/admin/get-permission/${encodeURIComponent(userId.value)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.data) {
                            data.data.forEach(element => {
                                const checkbox = document.getElementById(`permission_${element.id}`);
                                if (checkbox) {
                                    checkbox.checked = true;
                                }else{
                                    checkbox.checked = false;
                                }
                            });
                        }
                    })
                }
            })
        }

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
                        <button class="btn btn-primary fs-4 px-3" data-bs-toggle="tooltip" id="submitButton" data-bs-placement="top" data-bs-title="Save"><i class="fa-solid fa-floppy-disk"></i></button>
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
                            <div class="row g-4 px-4">
                                <div class="col-md-12">
                                    <label for="user_id">User Name</label>
                                    <select name="user_id" id="user_id" class="form-control mt-2">
                                        <option value="">--Select User--</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }} <span>({{ $user->email }})</span></option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="errors">
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Permission</h4>
                                        </div>
                                        <div class="card-body" style="max-height: 300px; overflow-y:auto">
                                            @error('permission_ids')
                                                <div class="errors">
                                                    <span class="text-danger">
                                                        {{$message}}
                                                    </span>
                                                </div>
                                            @enderror
                                            <div class="row">
                                                @foreach ($permissions as $permission)
                                                    <div class="col-sm-3 mt-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input border-dark" name="permissions[]" id="permission_{{ $permission->id }}" type="checkbox" value="{{ $permission->name }}">
                                                            <label class="text-muted text-capitalize">{{ str_replace('_', ' ', $permission->name) }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection