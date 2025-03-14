@extends('frontend.common.base')

@push('setTitle') {{$heading_title}} @endpush

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
                            <a href="{{ route('frontend.chapter') . '/create' }}" class="btn btn-primary btn-sm px-1 d-flex align-items-center">
                                <i class="lni lni-plus fs-4"></i> Add Chapter &nbsp;
                            </a>
                        </div>
                    </div>
                </div>

                <div class="py-3" style="text-align: justify">
                    @include('frontend.common.alert')
                    <div class="card p-3 bg-light">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="30%">Chapter Name</th>   
                                    <th width="20%">Sort By</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($category as $cat)
                                    <tr>
                                        <td>{{ $category->firstItem() + $loop->index }}</td>
                                        <td>{{ $cat->name }}</td>
                                        <td>{{ $cat->sort_by }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a class="btn btn-primary btn-sm" href="{{ route('frontend.chapter.edit', $cat->id) }}">
                                                    <i class="lni lni-pencil-1"></i>
                                                </a>
                                                <form action="{{ route('frontend.chapter.destroy', $cat->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm deleteRow" data-name="{{ $cat->name }}" data-row-name="Post" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                        <i class="lni lni-trash-3"></i>
                                                    </button>                                       
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <caption class="text-center">Not created any note</caption>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $category->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection