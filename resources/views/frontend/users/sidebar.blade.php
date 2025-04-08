<style>
  .note-sidebar {
    cursor: pointer;
  }
  .note-sidebar:hover {
    border: 1px solid #000;
  }
  .note-sidebar:hover .edit-button {
    opacity: 1 !important;
    border: 1px solid #000;
  }
</style>

<div class="shrink-0 p-2 bg-white h-full">
  <div class="flex justify-between items-center mb-2 border-b">
    <!-- Mobile Sidebar Button -->
    <div class="h-full flex items-center justify-end lg:hidden">
      <button class="text-black border p-2 rounded" type="button" onclick="toggleMobileSidebar()">
        <i class="lni lni-menu-hamburger-1 mt-1"></i>
      </button>
    </div>

    <!-- Logo -->
    <p class="flex items-center no-underline mb-0 py-3">
      <span class="text-xl font-semibold">LearnStacks</span>
    </p>

    <!-- Mobile User Dropdown -->
    <div class="mb-1 md:hidden">
      @if (Auth::check() && Auth::user()->role === 'user')
        <div class="relative text-end" id="mobileUserDropdownWrapper">
          <button type="button" id="mobileUserDropdownToggle" class="text-3xl bg-transparent">
            <img src="{{ Auth::user()?->avatar }}" alt="Learn Stacks" class="rounded-full w-[50px] h-[50px] mt-0" />
          </button>

          <ul id="mobileUserDropdownMenu" class="absolute right-0 text-left mt-2 bg-white border rounded shadow text-sm hidden z-50 w-[170px]">
            <li><a class="block px-4 py-2 text-black hover:bg-gray-100" href="{{ route('frontend.dashboard') }}"><i class="lni lni-dashboard-square-1 mr-2"></i>Dashboard</a></li>
            <li><a class="block px-4 py-2 text-black hover:bg-gray-100" href="#"><i class="lni lni-user-4 mr-2"></i>Profile</a></li>
            <li><a class="block px-4 py-2 text-black hover:bg-gray-100" href="{{ route('frontend.chapter') }}"><i class="lni lni-menu-cheesburger mr-2"></i>Chapter List</a></li>
            <li><a class="block px-4 py-2 text-black hover:bg-gray-100" href="{{ route('frontend.note') }}"><i class="lni lni-notebook-1 mr-2"></i>Note List</a></li>
            <li><a class="block px-4 py-2 text-red-600 hover:bg-gray-100" href="{{ route('frontend.logout') }}"><i class="lni lni-power-button mr-2"></i>Logout</a></li>
          </ul>
        </div>
      @else
        <a class="bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded" href="{{ route('frontend.login') }}">Login</a>
      @endif
    </div>    
  </div>

  <!-- Desktop Sidebar -->
  <ul class="list-none pl-0 hidden lg:block" id="desktopSidebar">
    <li class="mb-1">
      <button class="w-full flex text-left py-2 px-3 rounded hover:bg-gray-100" onclick="toggleCollapse('default')">
        <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
        </svg> Default
      </button>
      <div class="pl-3 hidden" id="collapse-default">
        <ul class="list-none text-sm pb-1">
          @foreach ($service_notes as $note)
            @if (!$note->category_id)
              <li><a href="{{ route('frontend.note.show', $note->id) }}" class="block rounded pl-4 py-1 hover:bg-gray-100"><i class="lni lni-check-circle-1 text-green-600 mr-1"></i> {{ $note->name }}</a></li>
            @endif
          @endforeach
        </ul>
      </div>
    </li>

    @foreach ($service_note_categories as $category)
      <li class="mb-1">
        <div class="note-sidebar flex justify-between items-center relative group">         
          <button class="flex text-left w-full py-2 px-3 rounded hover:bg-gray-100" onclick="toggleCollapse('{{ $category->id }}')">
            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
            </svg> {{ $category->name }}
          </button>
          <div class="edit-button absolute right-2 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
            <a class="text-black border px-1 py-0 text-sm rounded" href="{{ route('frontend.chapter.edit', $category->id) }}"><i class="lni lni-pencil-1 text-lg"></i></a>
          </div>
        </div>
        <div class="pl-3 hidden" id="collapse-{{ $category->id }}">
          <ul class="list-none text-sm pb-1">
            @foreach ($service_notes as $note)
              @if ($note->category_id == $category->id)
                <li><a href="{{ route('frontend.note.show', $note->id) }}" class="block rounded pl-4 py-1 hover:bg-gray-100"><i class="lni lni-check-circle-1 text-green-600 mr-1"></i> {{ $note->name }}</a></li>
              @endif
            @endforeach
          </ul>
        </div>
      </li>
    @endforeach
  </ul>
</div>

<!-- Mobile Sidebar -->
<div id="mobileSidebar" class="fixed inset-0 bg-white z-50 transform -translate-x-full transition-transform duration-300">
  <div class="flex items-center justify-between p-4 border-b">
    <h5 class="text-lg font-semibold"><i class="fa-solid fa-list"></i> Navigation</h5>
    <button type="button" onclick="toggleMobileSidebar()" class="text-black">✕</button>
  </div>
  <div class="p-4">
    <ul class="list-none pl-0">
      <li class="mb-1">
        <button class="w-full text-left py-2 px-3 rounded hover:bg-gray-100" onclick="toggleCollapse('mobile_default')">Default</button>
        <div class="pl-3 hidden" id="collapse-mobile_default">
          <ul class="list-none text-sm pb-1">
            @foreach ($service_notes as $note)
              @if (!$note->category_id)
                <li><a href="{{ route('frontend.note.show', $note->id) }}" class="block rounded py-1 hover:bg-gray-100"><i class="lni lni-check-circle-1 text-green-600 mr-1"></i> {{ $note->name }}</a></li>
              @endif
            @endforeach
          </ul>
        </div>
      </li>

      @foreach ($service_note_categories as $category)
        <li class="mb-1">
          <div class="note-sidebar flex justify-between items-center relative group">
            <button class="text-left w-full py-2 px-3 rounded hover:bg-gray-100" onclick="toggleCollapse('mobile_{{ $category->id }}')">{{ $category->name }}</button>
            <div class="edit-button absolute right-2 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
              <a class="text-black border px-1 py-0 text-sm rounded" href="{{ route('frontend.chapter.edit', $category->id) }}">
                <i class="lni lni-pencil-1 text-lg"></i>
              </a>
            </div>
          </div>
          <div class="pl-3 hidden" id="collapse-mobile_{{ $category->id }}">
            <ul class="list-none text-sm pb-1">
              @foreach ($service_notes as $note)
                @if ($note->category_id == $category->id)
                  <li><a href="{{ route('frontend.note.show', $note->id) }}" class="block rounded py-1 hover:bg-gray-100"><i class="lni lni-check-circle-1 text-green-600 mr-1"></i> {{ $note->name }}</a></li>
                @endif
              @endforeach
            </ul>
          </div>
        </li>
      @endforeach
    </ul>
  </div>
</div>

<script>
  function toggleCollapse(id) {
    const target = document.getElementById(`collapse-${id}`);
    if (target) {
      target.classList.toggle('hidden');
    }
  }

  function toggleMobileSidebar() {
    const sidebar = document.getElementById('mobileSidebar');
    sidebar.classList.toggle('-translate-x-full');
  }

  document.addEventListener('DOMContentLoaded', function () {
    const dropdownToggle = document.getElementById('mobileUserDropdownToggle');
    const dropdownMenu = document.getElementById('mobileUserDropdownMenu');

    dropdownToggle?.addEventListener('click', function (e) {
      e.stopPropagation();
      dropdownMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', function () {
      dropdownMenu?.classList.add('hidden');
    });
  });
</script>
