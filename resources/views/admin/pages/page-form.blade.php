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

                    <div class="px-3 py-2 title-list">
                        <p class="mb-0"><i class="fa-solid fa-pencil"></i> {{ $list_title }}</p>
                    </div>
                    <div class="card rounded-0 p-3 mb-3 ">
                        <form action="{{$action}}" id="saveForm" method="post" enctype="multipart/form-data">
                            @csrf
                            @if (isset($page))
                                @method('PUT')
                            @endif
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="name">Name</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name', $page->name ?? '') }}">
                                            @error('name')
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
                                            <label for="description">description</label>
                                        </div>
                                        <div class="col-10">
                                            <textarea name="description" class="form-control" id="summernote" rows="10" placeholder="Description">{{ old('description', $page->description ?? '') }}</textarea>
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
                                            <label for="keywords">Keywords</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" name="keywords" class="form-control" placeholder="Keywords" value="{{ old('keywords', $page->keywords ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="robots">Robots</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" name="robots" class="form-control" placeholder="Robots" value="{{ old('robots', $page->robots ?? 'index, follow') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="googlebot">Google Bot</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" name="googlebot" class="form-control" placeholder="Google Bot" value="{{ old('googlebot', $page->googlebot ?? 'index, follow') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="tags">Tags</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" name="tags" class="form-control" placeholder="Tags" value="{{ old('tags', $page->tags ?? '') }}">
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