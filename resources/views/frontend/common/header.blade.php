
<header class="">

</header>

<nav class="p-1 sticky-top bg-black">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-3">
                <a href="/"><img height="60" width="100" src="{{ asset('logo.JPG') }}" alt="ez lifestyle"></a>
            </div>

            <!-- For desktop -->
            <div class="col-6 col-md-9 ">
                <div class="mt-3 d-desktop d-phone">
                    <ul class="list-unstyled text-white d-flex justify-content-end mb-0">
                        <li class="px-3 fs-5 navbar_items"><a class="text-decoration-none text-grey" href="/">Home</a></li>
                        <li class="px-3 fs-5 navbar_items"><a class="text-decoration-none text-grey" href="/">Laravel</a></li>
                        <li class="px-3 fs-5 navbar_items"><a class="text-decoration-none text-grey" href="/">CSS</a></li>
                        <li class="px-3 fs-5 navbar_items"><a class="text-decoration-none text-grey" href="/">JavaScript</a></li>
                        <li class="px-3 fs-5 navbar_items"><a class="text-decoration-none text-grey" href="/">About Us</a></li>
                    </ul>
                </div>
                <div class="d-phone d-tab text-end h-100">
                    <div class="h-100 d-flex align-items-center justify-content-end">
                        <button class="btn text-white border" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><i class="fa-solid fa-bars fs-3 mt-1"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- For mobile -->
        <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasLabel"><i class="fa-solid fa-list"></i> Navigation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <ul class="list-unstyled mb-0">
                <li class="px-3 fs-5 navbar_items"><a class="text-decoration-none d-block text-dark" href="/"><i class="fa-solid text-dark fa-house"></i> Home</a></li>
            <hr>
          </div>
        </div>
    </div>
</nav>