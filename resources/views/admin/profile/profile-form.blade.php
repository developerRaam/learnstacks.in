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
                        <a class="btn btn-primary fs-4 px-3" href="{{$back}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Back"><i class="fa-solid fa-reply"></i></a>
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
                    @if ($profile)
                        <div class="card rounded-0 p-3 mb-3 ">
                            <form action="{{$action}}" id="saveForm" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row mb-4">
                                    <div class="col-2 text-end">
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" id="name" name="name" class="form-control p-2" value="{{ old('name', $profile->name ?? '') }}" placeholder="Name">
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
                                        <label for="email">Email</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" id="email" name="email" class="form-control p-2" value="{{ old('email', $profile->email ?? '') }}" placeholder="Email">
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
                                        <label for="image">Avatar</label>
                                    </div>
                                    <div class="col-10">
                                        <div class="card p-2" style="width: 12rem">
                                            <img src="{{ isset($profile->avatar) ? asset('storage/'.$profile->avatar) : asset('not-image-available.png')}}" alt="Profile Avatar" id="imagePreview"  onclick="triggerFileUpload()" style="width: 100%; aspect-ratio: 9 / 9; object-fit: cover;">
                                            <input type="file" name="avatar" id="imageUpload" accept="image/*" style="display: none;" onchange="previewImage(event)">
                                            @error('image')
                                                <div class="errors">
                                                    <span class="text-danger">
                                                        {{$message}}
                                                    </span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>

        // Form save 
        document.addEventListener("DOMContentLoaded", function() {
            let submitButton = document.getElementById("submitButton");
            let form = document.getElementById("saveForm");

            submitButton.addEventListener("click", function() {
                form.submit(); // This will submit the form when the button is clicked
            });
        });

        function previewImage(event) {
            const input = event.target;
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById(`imagePreview`);
                    img.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        function triggerFileUpload(index) {
            document.getElementById(`imageUpload`).click();
        }

    </script>
</section>
@endsection