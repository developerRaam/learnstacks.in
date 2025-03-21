<div class="container-fluid px-0">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($banners as $index => $banner)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }} position-relative" data-bs-interval="{{ $index * 5000 }}">
                    <img class="d-block w-100" src="{{ asset('storage') . '/' . $banner->image }}" alt="{{ $banner->title }}">
                    <div class="position-absolute w-100 d-flex align-items-center justify-content-center h-100" style="z-index: 100; width: 100%; top: 0; background-color: #0000007d">
                        <div class="col-md-7 p-2">
                            @if (!empty($banner->title))
                                <h1 class="text-white mb-3 text-center animate__animated animate__fadeInDown banner_heading" style="font-size: 4rem">{{ $banner->title }}</h1>
                            @endif
                            
                            @if (!empty($banner->description))
                                <p class="text-white fs-3 text-center banner_description" style="text-align: justify">{{ $banner->description }}</p>
                            @endif
                            
                            @if (!empty($banner->button_text))
                                <div class="text-center mt-3">
                                    <a href="{{$banner->button_url}}" class="btn btn-primary" style="background-color: {{$banner->button_background}}; color:{{$banner->button_color}}; border-color:{{$banner->border_color}}">{{ $banner->button_text }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($banners->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev" style="z-index: 999">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next" style="z-index: 999">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
        @endif
    </div>
</div>
