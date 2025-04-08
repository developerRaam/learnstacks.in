<header class="">

</header>

<nav class="p-1 sticky top-0 bg-black z-50">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="flex flex-wrap items-center justify-between ">
            <div class="w-1/2 md:w-1/4">
                <a href="/">
                    <img class="h-14 w-auto" src="{{ asset('storage') .'/'. app('settings')['site_logo'] }}" alt="Learn Stacks">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="w-1/2 md:w-3/4 hidden md:flex justify-end items-center space-x-4">
                <ul class="flex items-center text-white space-x-6 mb-0">
                    <li><a class="no-underline text-gray-300 hover:text-white text-sm" href="/">Home</a></li>
                    @foreach ($service_categories as $category)
                        <li><a class="no-underline text-gray-300 hover:text-white text-sm" href="{{ route('frontend.post', $category->slug) }}">{{ $category->name }}</a></li>
                    @endforeach
                    <li><a class="no-underline text-gray-300 hover:text-white text-sm" href="{{ route('frontend.page', 'about-us') }}">About Us</a></li>
                    <li class="relative group" id="userDropdownWrapper">
                        @if (Auth::check() && Auth::user()->role === 'user')
                            <!-- Trigger Button -->
                            <button id="userDropdownToggle" class="focus:outline-none">
                                <img class="w-12 h-12 rounded-full object-cover" src="{{ Auth::user()?->avatar }}" alt="User">
                            </button>
                    
                            <!-- Dropdown Menu -->
                            <ul id="userDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg text-sm z-50 hidden">
                                <li>
                                    <a href="{{ route('frontend.dashboard') }}" class="block px-4 py-2 text-slate-700 hover:bg-gray-100">
                                        <i class="lni lni-dashboard-square-1 mr-2"></i>Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="block px-4 py-2 text-slate-700 hover:bg-gray-100">
                                        <i class="lni lni-user-4 mr-2"></i>Profile
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('frontend.chapter') }}" class="block px-4 py-2 text-slate-700 hover:bg-gray-100">
                                        <i class="lni lni-menu-cheesburger mr-2"></i>Chapter List
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('frontend.note') }}" class="block px-4 py-2 text-slate-700 hover:bg-gray-100">
                                        <i class="lni lni-notebook-1 mr-2"></i>Note List
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('frontend.logout') }}" class="block px-4 py-2 text-red-500 hover:bg-gray-100">
                                        <i class="lni lni-power-button mr-2"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        @else
                            <a href="{{ route('frontend.login') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Login
                            </a>
                        @endif
                    </li>
                    
                </ul>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex justify-end items-center">
                <button class="text-white border px-3 py-2 rounded" type="button" id="menuToggle">
                    <i class="lni lni-menu-hamburger-1 mt-1"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Offcanvas -->
        <div id="mobileMenu" class="fixed inset-0 bg-white z-50 transform translate-x-full transition-transform duration-300 ease-in-out">
            <div class="flex items-center justify-between p-4 border-b">
                <h5 class="text-lg font-semibold"><i class="fa-solid fa-list"></i> Navigation</h5>
                <button class="text-black text-2xl" id="menuClose">✖</button>
            </div>
            <div class="p-4 space-y-4">
                <ul class="space-y-4">
                    <li>
                        <a class="no-underline text-gray-800 hover:text-black flex items-center" href="/">
                            <i class="fa-solid fa-house mr-2"></i> Home
                        </a>
                    </li>
                    @foreach ($service_categories as $category)
                        <li>
                            <a class="no-underline text-gray-800 hover:text-black flex items-center" href="{{ route('frontend.post', $category->slug) }}">
                                <i class="fa-solid fa-folder mr-2"></i> {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a class="no-underline text-gray-800 hover:text-black flex items-center" href="{{ route('frontend.page', 'about-us') }}">
                            <i class="fa-solid fa-info-circle mr-2"></i> About Us
                        </a>
                    </li>
                    @if (Auth::check())
                        <li>
                            <a class="no-underline text-gray-800 hover:text-black flex items-center" href="#">
                                <i class="fa-solid fa-user mr-2"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a class="no-underline text-red-600 hover:text-red-800 flex items-center" href="{{ route('frontend.logout') }}">
                                <i class="fa-solid fa-power-off mr-2"></i> Logout
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="no-underline text-blue-600 hover:text-blue-800 flex items-center" href="{{ route('frontend.login') }}">
                                <i class="fa-solid fa-sign-in-alt mr-2"></i> Login
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const toggle = document.getElementById("menuToggle");
        const menu = document.getElementById("mobileMenu");
        const close = document.getElementById("menuClose");

        toggle.addEventListener("click", () => {
            menu.classList.remove("translate-x-full");
        });

        close.addEventListener("click", () => {
            menu.classList.add("translate-x-full");
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('userDropdownToggle');
        const menu = document.getElementById('userDropdownMenu');

        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            menu.classList.toggle('hidden');
        });

        document.addEventListener('click', function () {
            if (!menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });
    });
</script>


