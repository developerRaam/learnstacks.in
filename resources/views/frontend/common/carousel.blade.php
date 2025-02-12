<div>
    @foreach ($banners as $banner)
        <img class="w-100" src="{{ asset('storage') . '/' . $banner->image }}" alt="">
    @endforeach
</div>