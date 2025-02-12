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

        // Site logo
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

                                <!-- Site Setting setting -->
                                <div class="col-12 mt-4">
                                    <h4 class="bg-secondary text-white p-2 px-2 fs-6 rounded">Site Setting</h4>
                                </div>

                                <div class="col-md-4">
                                    <label for="site_logo">Site Logo</label>
                                    <div class="card p-2 mt-3" style="width: 12rem">
                                        <img src="{{ isset($setting->site_logo) ? asset('storage/'.$setting->site_logo) : asset('not-image-available.png')}}" alt="Social Media Icon" id="imagePreview"  onclick="triggerFileUpload()" style="width: 100%; aspect-ratio: 9 / 9; object-fit: cover;">
                                        <input type="file" name="site_logo" id="imageUpload" accept="image/*" style="display: none;" onchange="previewImage(event)">
                                        @error('site_logo')
                                            <div class="errors">
                                                <span class="text-danger">
                                                    {{$message}}
                                                </span>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <label for="site_description">Site Description</label>
                                    <textarea id="site_description" name="site_description" class="form-control p-2 mt-3" rows="7" placeholder="Site Description">{{ old('site_description', $setting->site_description ?? '') }}</textarea>
                                    @error('site_description')
                                        <div class="errors">
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        </div>
                                    @enderror
                                </div>

                                <!-- Social Media setting -->
                                <div class="col-12 mt-4">
                                    <h4 class="bg-secondary text-white p-2 px-2 fs-6 rounded">Social Media</h4>
                                </div>

                                <div class="col-md-6">
                                    <label for="social_media_facebook_url">Facebook url</label>
                                    <input type="text" id="social_media_facebook_url" name="social_media_facebook_url" class="form-control p-2 mt-3" value="{{ old('social_media_facebook_url', $setting->social_media_facebook_url ?? '') }}" placeholder="Facebook url">
                                    @error('social_media_facebook_url')
                                        <div class="errors">
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        </div>
                                    @enderror
                               </div>

                               <div class="col-md-6">
                                   <div class="col-12">
                                       <label for="social_media_instagram_url">Instagram url</label>
                                       <input type="text" id="social_media_instagram_url" name="social_media_instagram_url" class="form-control p-2 mt-3" value="{{ old('social_media_instagram_url', $setting->social_media_instagram_url ?? '') }}" placeholder="Instagram url">
                                       @error('social_media_instagram_url')
                                           <div class="errors">
                                               <span class="text-danger">
                                                   {{$message}}
                                               </span>
                                           </div>
                                       @enderror
                                   </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="col-12">
                                        <label for="social_media_twitter_url">Twitter url</label>
                                        <input type="text" id="social_media_twitter_url" name="social_media_twitter_url" class="form-control p-2 mt-3" value="{{ old('social_media_twitter_url', $setting->social_media_twitter_url ?? '') }}" placeholder="Twitter url">
                                        @error('social_media_twitter_url')
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
                </div>
            </div>
        </div>
    </div>
</section>
@endsection