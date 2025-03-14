@extends('frontend.common.base')

@push('setTitle') {{ isset($note) ?  'Edit' : 'Add' }} Note @endpush

@push('addStyle')
    <!-- summernote -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
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

    // start summernote 
    $(document).ready(function() {
        $('#summernote').summernote({
        height: 300,
        toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica Neue', 'Helvetica', 'Impact', 'Lucida Grande', 'Tahoma', 'Times New Roman', 'Verdana'],
            fontNamesIgnoreCheck: ['Helvetica Neue', 'Helvetica', 'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Impact', 'Lucida Grande', 'Tahoma', 'Times New Roman', 'Verdana'],
        });
        
        // upload images
        $('#summernote').on('summernote.image.upload', function(we, files) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#summernote').summernote('insertImage', e.target.result, function($image) {
                    $image.css('display', 'block').css('margin', '0 auto');
                });
            };
            reader.readAsDataURL(files[0]);
        });
        
        // toggle
        $(document).on('click', '.note-toolbar .dropdown-toggle', function(e) {
            e.preventDefault(); // Prevent default action
            e.stopPropagation(); // Stop event propagation

            // Initialize Bootstrap 5 dropdown manually
            let dropdown = bootstrap.Dropdown.getInstance(this) || new bootstrap.Dropdown(this);
            dropdown.toggle();
        });

        $(document).on('click', function() {
            $('.note-dropdown-menu.show').removeClass('show');
        });
    });
    // end summernote
</script>
@endpush

@section('content')

    <div class="container-fluid px-3 bg-white mb-0">
        <div class="row">
            <div class="col-md-3">
                @include('frontend.users.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card py-2 mt-3 px-2 overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <a class="btn btn-primary btn-sm me-3" href="{{ url()->previous() }}">Back</a>
                            <h2 class="fs-5 mb-0">{{$heading_title}}</h2>
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
                            <button class="btn btn-primary btn-sm" id="submitButton">Save</button>
                        </div>
                    </div>
                </div>

                <div class="py-3" style="text-align: justify">
                    @include('frontend.common.alert')
                    <div class="card p-3 bg-light">
                        <form id="saveForm" action="{{ $action}}" method="post">
                            @csrf
                            @if (isset($note))
                                @method('PUT')
                            @endif
                            <div class="mb-3">
                                <label class="mb-2" for="name">Title</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Title" value="{{ old('name', $note->name ?? '') }}">
                                @error('name')
                                    <p class="text-danger mb-0">{{ $message }}</p>
                                @enderror
                            </div> 

                            <div class="mb-3">
                                <label class="mb-2" for="category_id">Chapter Name</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">--Select Chapter</option>
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->id }}" @if(isset($note) && $cat->id == $note->category_id) selected @endif>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <p class="text-muted mt-1" style="font-size:12px">(Chapter name is optional)</p>
                                @error('category_id')
                                    <p class="text-danger mb-0">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="mb-2" for="description">Description</label>
                                <textarea name="description" class="form-control" id="summernote" rows="10" placeholder="Description">{{ old('description', $note->description ?? '') }}</textarea>
                                @error('description')
                                    <p class="text-danger mb-0">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="mb-2" for="sort_by">Sort By</label>
                                <input type="text" class="form-control" name="sort_by" id="sort_by" placeholder="Sort by" value="{{ old('sort_by', $note->sort_by ?? '0') }}">
                                @error('sort_by')
                                    <p class="text-danger mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection