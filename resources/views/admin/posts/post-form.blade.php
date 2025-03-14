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
                            @if (isset($post))
                                @method('PUT')
                            @endif
                            <input type="hidden" name="user_id" value="{{ $post->user_id ?? '' }}">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="title">Title</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" name="title" class="form-control" placeholder="Title" value="{{ old('title', $post->title ?? '') }}">
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
                                            <label for="slug">Slug</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" name="slug" class="form-control" placeholder="Slug" value="{{ old('slug', $post->slug ?? '') }}">
                                            @error('slug')
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
                                            <label for="description">Description</label>
                                        </div>
                                        <div class="col-10">
                                            <textarea name="description" class="form-control" id="summernote" rows="10" placeholder="Description">{{ old('description', $post->description ?? '') }}</textarea>
                                            @error('description')
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
                                            <label for="short_description">Short Description</label>
                                        </div>
                                        <div class="col-10">
                                            <textarea name="short_description" id="short_description" class="form-control" rows="3" placeholder="Short Description">{{ old('short_description', $post->short_description ?? '') }}</textarea>
                                            @error('short_description')
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
                                            <label for="category">Category</label>
                                        </div>
                                        <div class="col-8">
                                            <select class="form-control" name="category_id" id="category">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" @if(isset($post) && $post->category_id == $category->id) selected @endif >{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div> 

                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="sub_category">Sub Category</label>
                                        </div>
                                        <div class="col-8">
                                            <select class="form-control" name="sub_category_id" id="sub_sategory">
                                                <option value="">Select Sub Category</option>
                                               
                                            </select>
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
                                                <img src="{{ isset($post) && $post->featured_image ? asset('storage').'/'.$post->featured_image : asset('not-image-available.png')}}" alt="Profile image" id="imagePreview"  onclick="triggerFileUpload()" style="width: 100%; aspect-ratio: 9 / 9; object-fit: cover;">
                                                <input type="file" name="featured_image" id="imageUpload" accept="image/*" style="display: none;" onchange="previewImage(event)">
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
                                            <label for="keywords">Keywords</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" name="keywords" class="form-control" placeholder="Keywords" value="{{ old('keywords', $post->keywords ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="robots">Robots</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" name="robots" class="form-control" placeholder="Robots" value="index, follow">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="googlebot">Google Bot</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" name="googlebot" class="form-control" placeholder="Google Bot" value="index, follow">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="tags">Tags</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" name="tags" class="form-control" placeholder="Tags" value="{{ old('tags', $post->tags ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="canonical">Canonical</label>
                                        </div>
                                        <div class="col-10">
                                        </div>
                                    </div>
                                </div> --}}
                                <input type="hidden" name="canonical" class="form-control" placeholder="Canonical" value="{{ old('canonical', $post->canonical ?? '') }}">

                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="status">Status</label>
                                        </div>
                                        <div class="col-8">
                                            <select class="form-control" name="status" id="status">
                                                <option value="Draft" @if(isset($post) && $post->status == "Draft") selected @endif>Draft</option>
                                                <option value="Published" @if(isset($post) && $post->status == "Published") selected @endif>Published</option>
                                                <option value="Archived" @if(isset($post) && $post->status == "Archived") selected @endif>Archived</option>
                                            </select>
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