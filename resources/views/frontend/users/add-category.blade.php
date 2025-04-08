@extends('frontend.common.base')

@push('setTitle') {{ isset($category) ? 'Edit' : 'Add' }} Chapter @endpush

@push('addScript')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("submitButton").addEventListener("click", function() {
            document.getElementById("saveForm").submit();
        });
    });
</script>
@endpush

@section('content')

<div class="w-full px-4 bg-white">
    <div class="flex flex-col lg:flex-row gap-4">
        <div class="w-full lg:w-1/4">
            @include('frontend.users.sidebar')
        </div>
        <div class="w-full lg:w-3/4">
            <div class="bg-white shadow rounded py-3 px-4 mt-4 overflow-hidden">
                <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ url()->previous() }}" class="bg-blue-600 text-white text-sm px-3 py-1 rounded hover:bg-blue-700">Back</a>
                        <h2 class="text-lg font-semibold">{{ $heading_title }}</h2>
                        <ul class="text-sm text-gray-600 ml-2" aria-label="Breadcrumb">
                                <ol class="flex items-center space-x-1">
                                  @foreach ($breadcrumbs as $index => $breadcrumb)
                                    <li class="flex items-center">
                                      @if ($breadcrumb['href'])
                                        <a href="{{ $breadcrumb['href'] }}" class="text-blue-600 hover:underline">
                                          {{ $breadcrumb['text'] }}
                                        </a>
                                      @else
                                        <span class="text-gray-500">{{ $breadcrumb['text'] }}</span>
                                      @endif
                              
                                      @if (!$loop->last)
                                        <svg class="w-4 h-4 mx-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                          <path d="M7.05 4.05a.75.75 0 011.06 0L13 8.94a.75.75 0 010 1.06l-4.89 4.89a.75.75 0 11-1.06-1.06L11.44 10 7.05 5.61a.75.75 0 010-1.06z"/>
                                        </svg>
                                      @endif
                                    </li>
                                  @endforeach
                                </ol>
                            </ul>
                    </div>
                    <div>
                        <button id="submitButton" class="bg-blue-600 text-white text-sm px-4 py-1.5 rounded hover:bg-blue-700">Save</button>
                    </div>
                </div>
            </div>

            <div class="py-4">
                @include('frontend.common.alert')

                <div class="bg-gray-100 p-5 rounded shadow">
                    <form id="saveForm" action="{{ $action }}" method="POST">
                        @csrf
                        @if (isset($category))
                            @method('PUT')
                        @endif

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium mb-2">Chapter Name</label>
                            <input type="text" id="name" name="name" placeholder="Chapter name"
                                   class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                   value="{{ old('name', $category->name ?? '') }}">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="sort_by" class="block text-sm font-medium mb-2">Sort By</label>
                            <input type="text" id="sort_by" name="sort_by" placeholder="Sort by"
                                   class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                   value="{{ old('sort_by', $category->sort_by ?? '') }}">
                            @error('sort_by')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection