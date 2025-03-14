@extends('frontend.common.base')

@push('setTitle') Home @endpush

@section('content')

    <div class="container-fluid px-3 bg-white mb-0">
        <div class="row">
            <div class="col-md-3">
                @include('frontend.users.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card py-2 mt-3 px-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
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
                            <div class="d-flex justify-content-end align-items center gap-2">
                                <a href="{{ route('frontend.note') . '/create' }}" class="btn btn-primary btn-sm px-1 d-flex align-items-center">
                                    <i class="lni lni-plus fs-4"></i> Add Note &nbsp;
                                </a>
                                <a href="{{ route('frontend.chapter') . '/create' }}" class="btn btn-primary btn-sm px-1 d-flex align-items-center">
                                    <i class="lni lni-plus fs-4"></i> Add Chapter &nbsp;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="py-3" style="text-align: justify">
                    <div class="card p-3 bg-light">
                        <div class="d-flex justify-content-between">
                            <h1 class="fs-4 mb-0">{{ $note->name }}</h1>
                            <a href="{{ route('frontend.note.edit', $note->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        </div><hr>

                        <div>
                            {!! $note->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection