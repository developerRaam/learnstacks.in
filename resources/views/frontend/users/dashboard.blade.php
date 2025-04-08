@extends('frontend.common.base')

@push('setTitle') Home @endpush

@section('content')

<div class="w-full px-3 bg-white mb-0">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="w-full md:w-1/4">
            @include('frontend.users.sidebar')
        </div>

        <div class="w-full md:w-3/4">
            <div class="bg-white rounded shadow py-2 mt-3 px-3 overflow-hidden">
                <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                    <div class="flex flex-wrap items-center gap-3">
                        <h2 class="text-lg font-semibold mb-0">{{ $heading_title }}</h2>
                        <div>
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
                    <div class="flex gap-2">
                        <a href="{{ route('frontend.note') . '/create' }}" class="bg-blue-600 text-white text-sm px-3 py-1 rounded flex items-center hover:bg-blue-700">
                            <i class="lni lni-plus text-lg mr-1"></i> Add Note
                        </a>
                        <a href="{{ route('frontend.chapter') . '/create' }}" class="bg-blue-600 text-white text-sm px-3 py-1 rounded flex items-center hover:bg-blue-700">
                            <i class="lni lni-plus text-lg mr-1"></i> Add Chapter
                        </a>
                    </div>
                </div>
            </div>

            <div class="py-3">
                <div class="w-full overflow-hidden rounded shadow">
                    <img class="w-full h-auto" src="{{ asset('online-notes.jpg') }}" alt="Learn Stacks online notes">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection