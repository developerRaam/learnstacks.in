@extends('frontend.common.base')

@push('setTitle') Dashboard @endpush

@section('content')

<div class="w-full px-3 bg-white mb-0">
    <div class="flex flex-col md:flex-row">
        <div class="w-full md:w-1/4">
            @include('frontend.users.sidebar')
        </div>
        <div class="w-full md:w-3/4">
            <div class="bg-white rounded shadow py-2 mt-3 px-2">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <h2 class="text-lg font-semibold mb-0">{{ $heading_title }}</h2>
                        <div class="ml-3">
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
                    </div>
                    <div class="flex justify-end items-center gap-2">
                        <a href="{{ route('frontend.note') . '/create' }}" class="bg-blue-600 text-white text-sm px-3 py-1 rounded flex items-center hover:bg-blue-700">
                            <i class="lni lni-plus text-lg mr-1"></i> Add Note
                        </a>
                        <a href="{{ route('frontend.chapter') . '/create' }}" class="bg-blue-600 text-white text-sm px-3 py-1 rounded flex items-center hover:bg-blue-700">
                            <i class="lni lni-plus text-lg mr-1"></i> Add Chapter
                        </a>
                    </div>
                </div>
            </div>

            <div class="py-3 text-justify">
                <div class="bg-gray-100 p-4 rounded shadow">
                    <div class="flex justify-between items-center mb-2">
                        <h1 class="text-lg font-semibold">{{ $note->name }}</h1>
                        <a href="{{ route('frontend.note.edit', $note->id) }}" class="bg-blue-600 text-white text-sm px-3 py-1 rounded hover:bg-blue-700">Edit</a>
                    </div>
                    <hr class="my-2 border-gray-300">
                    <div>
                        {!! $note->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection