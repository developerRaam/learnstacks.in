<div>
    @foreach ($banners as $banner)
        <img class="w-100" src="{{ asset('storage') . '/' . $banner->image }}" alt="{{ $banner->title }}" style="aspect-ratio: 16 / 9;max-height: 500px;">
    @endforeach
</div>