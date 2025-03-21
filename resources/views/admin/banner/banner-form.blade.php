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
                    <div class="card rounded-0 p-3 mb-3 ">
                        <form action="{{$action}}" id="saveForm" method="post" enctype="multipart/form-data">
                            @csrf
                            @if (isset($banner))
                                @method('PUT')
                            @endif
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="title">Title</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" name="title" class="form-control" placeholder="Title" value="{{ old('title', $banner->title ?? '') }}">
                                            @error('title')
                                                <div class="errors">
                                                    <span class="text-danger">
                                                        {{$message}}
                                                    </span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div> 

                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="status">Status</label>
                                        </div>
                                        <div class="col-8">
                                            <div class="col-8 form-check form-switch">
                                                <input type="hidden" name="status" value="0">
                                                <input class="form-check-input fs-3 m-0" id="status" name="status" type="checkbox" role="switch" {{ isset($banner) && $banner->status ? ($banner->status ? 'checked': '') : old('status') }}>
                                            </div>
                                        </div>
                                    </div>
                                </div> 

                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="image">Image</label>
                                        </div>
                                        <div class="col-8">
                                            <div class="card p-2" style="width: 12rem">
                                                <img src="{{ isset($banner->image) ? asset('storage/'.$banner->image) : asset('not-image-available.png')}}" alt="Profile image" id="imagePreview"  onclick="triggerFileUpload()" style="width: 100%; aspect-ratio: 9 / 9; object-fit: cover;">
                                                <input type="file" name="image" id="imageUpload" accept="image/*" style="display: none;" onchange="previewImage(event)">
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
                                </div>     
                                
                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="description">Description</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" name="description" class="form-control" placeholder="description" value="{{ old('description', $banner->description ?? '') }}">
                                        </div>
                                    </div>
                                </div> 

                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="button_text">Button Text</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" name="button_text" class="form-control" placeholder="Button text" value="{{ old('button_text', $banner->button_text ?? '') }}">
                                        </div>
                                    </div>
                                </div> 

                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="button_url">Button URL</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" name="button_url" class="form-control" placeholder="Button url" value="{{ old('button_url', $banner->button_url ?? '') }}">
                                        </div>
                                    </div>
                                </div> 

                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="button_background">Button Background color</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="color" name="button_background" class="form-control" value="{{ old('button_background', $banner->button_background ?? '') }}">
                                        </div>
                                    </div>
                                </div> 

                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="button_color">Button Text Color</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="color" name="button_color" class="form-control" value="{{ old('button_color', $banner->button_color ?? '') }}">
                                        </div>
                                    </div>
                                </div> 

                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="border_color">Button Border Color</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="color" name="border_color" class="form-control" value="{{ old('border_color', $banner->border_color ?? '') }}">
                                        </div>
                                    </div>
                                </div> 

                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="sort_by">Sort by</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" name="sort_by" class="form-control" placeholder="Sort by" value="{{ old('sort_by', $banner->sort_by ?? '') }}">
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