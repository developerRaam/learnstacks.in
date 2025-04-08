@extends('frontend.common.base')

@push('setTitle') {{ $heading_title }} @endpush

@section('content')

<div class="w-full px-3 bg-white mb-0">
    <div class="flex flex-col lg:flex-row gap-4">
        <div class="w-full lg:w-1/4">
            @include('frontend.users.sidebar')
        </div>

        <div class="w-full lg:w-3/4">
            <div class="bg-white shadow rounded py-2 mt-3 px-3 overflow-hidden">
                <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ url()->previous() }}" class="bg-blue-600 text-white text-sm px-3 py-1 rounded hover:bg-blue-700">Back</a>
                        <h2 class="text-lg font-semibold">{{ $heading_title }}</h2>
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
                    <div>
                        <a href="{{ route('frontend.chapter') . '/create' }}" class="bg-blue-600 text-white text-sm px-3 py-1 rounded flex items-center hover:bg-blue-700">
                            <i class="lni lni-plus text-lg mr-1"></i> Add Chapter
                        </a>
                    </div>
                </div>
            </div>

            <div class="py-3 text-justify">
                @include('frontend.common.alert')

                <div class="bg-gray-100 p-3 rounded shadow">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="px-4 py-2 w-[10%]">#</th>
                                    <th class="px-4 py-2 w-[30%]">Chapter Name</th>
                                    <th class="px-4 py-2 w-[20%]">Sort By</th>
                                    <th class="px-4 py-2 w-[20%]">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-300">
                                @forelse ($category as $cat)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $category->firstItem() + $loop->index }}</td>
                                        <td class="px-4 py-2">{{ $cat->name }}</td>
                                        <td class="px-4 py-2">{{ $cat->sort_by }}</td>
                                        <td class="px-4 py-2">
                                            <div class="flex gap-2">
                                                <a href="{{ route('frontend.chapter.edit', $cat->id) }}" class="bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700">
                                                    <i class="lni lni-pencil-1"></i>
                                                </a>
                                                <form action="{{ route('frontend.chapter.destroy', $cat->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700 deleteRow" data-name="{{ $cat->name }}" data-row-name="Post">
                                                        <i class="lni lni-trash-3"></i>
                                                    </button>                                       
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-gray-500">Not created any note</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center mt-4">
                        {{ $category->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection