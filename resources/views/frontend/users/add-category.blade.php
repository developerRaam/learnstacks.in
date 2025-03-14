@extends('frontend.common.base')

@push('setTitle') {{ isset($category) ?  'Edit' : 'Add' }} Chapter @endpush

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

    <div class="container-fluid px-3 bg-white mb-0">
        <div class="row">
            <div class="col-lg-3">
                @include('frontend.users.sidebar')
            </div>
            <div class="col-lg-9">
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
                        <form id="saveForm" action="{{ $action }}" method="post">
                            @csrf
                            @if (isset($category))
                                @method('PUT')
                            @endif
                            <div class="mb-3">
                                <label class="mb-2" for="name">Chapter Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Chapter name" value="{{ old('name', $category->name ?? '') }}">
                                @error('name')
                                    <p class="text-danger mb-0">{{ $message }}</p>
                                @enderror
                            </div> 
                            <div class="mb-3">
                                <label class="mb-2" for="sort_by">Sort By</label>
                                <input type="text" class="form-control" name="sort_by" id="sort_by" placeholder="Sort by" value="{{ old('sort_by', $category->sort_by ?? '') }}">
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