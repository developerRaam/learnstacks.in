<style>
  .note-sidebar{
    cursor: pointer;
  }
  .note-sidebar:hover {
      border: 1px solid #000;
  }
  .note-sidebar:hover .edit-button {
      opacity: 1 !important;
      border: 1px solid #000;
  }
  .btn-toggle:hover, .btn-toggle:focus {
      color: rgba(0, 0, 0, .85);
      background-color: transparent;
  }
</style>
<div class="flex-shrink-0 p-2 bg-white h-100">
    <div class="d-flex justify-content-between align-items-center mb-2 border-bottom">
        <div class="h-100 d-flex align-items-center justify-content-end d-lg-none">
            <button class="btn text-dark border" type="button" data-bs-toggle="offcanvas" data-bs-target="#noteSidebar" aria-controls="offcanvasScrolling"><i class="lni lni-menu-hamburger-1 mt-1"></i></button>
        </div>
        <p href="/" class="d-flex align-items-center link-dark text-decoration-none mb-0 py-3">
          <span class="fs-5 fw-semibold">LearnStacks</span>
        </p>
        <div class="mb-1 d-lg-none">
            @if (Auth::check() && Auth::user()->role === 'user')
              <div class="dropdown text-end">
                  <a class="dropdown-toggle fs-3 text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="background:transparent;">
                      <img src="{{ Auth::user()?->avatar }}" alt="Learn Stacks" style="border-radius: 50%; width:50px; height:50px;margin-top:0px;">
                  </a>
                  <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="{{ route('frontend.dashboard') }}"><i class="lni lni-dashboard-square-1"></i> Dashboard</a></li>
                      <li><a class="dropdown-item" href="#"><i class="lni lni-user-4"></i> Profile</a></li>
                      <li><a class="dropdown-item" href="{{ route('frontend.chapter') }}"><i class="lni lni-menu-cheesburger"></i> Chapter List</a></li>
                      <li><a class="dropdown-item" href="{{ route('frontend.note') }}"><i class="lni lni-notebook-1"></i> Note List</a></li>
                      <li><a class="dropdown-item text-danger d-flex align-items-center" href="{{ route('frontend.logout') }}"><i class="lni lni-power-button me-1"></i> Logout</a></li>
                  </ul>
              </div>
          @else
              <a class="btn btn-primary" href="{{ route('frontend.login') }}">Login</a>
          @endif
        </div>
    </div>

    <!-- Desktop --> 
    <ul class="list-unstyled ps-0 d-none d-lg-block">
      <li class="mb-1">
        <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#home-collapse_default" aria-expanded="true">
          Default
        </button>
        <div class="collapse show" id="home-collapse_default">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            @foreach ($service_notes as $note)
              @if ($note->category_id == null || $note->category_id == '')
                <li><a href="{{ route('frontend.note.show', $note->id) }}" class="link-dark rounded"><i class="lni lni-check-circle-1 fs-6 me-1 text-success"></i> {{ $note->name }}</a></li>    
              @endif
            @endforeach
          </ul>
        </div>
      </li>

      @foreach ($service_note_categories as $category)
        <li class="mb-1">
          <div class="note-sidebar d-flex justify-content-between align-items-center position-relative group">
            <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#home-collapse_{{$category->id}}" aria-expanded="true">
                {{ $category->name }}
            </button>
            <div class="edit-button" style="opacity: 0; transition: opacity 0.3s;">
                <a class="btn btn-light border btn-sm px-1 p-0" href="{{ route('frontend.chapter.edit', $category->id) }}">
                    <i class="lni lni-pencil-1 fs-5"></i>
                </a>
            </div>
          </div>

          <div class="collapse" id="home-collapse_{{$category->id}}">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              @foreach ($service_notes as $note)
                @if ($category->id == $note->category_id)
                  <li><a href="{{ route('frontend.note.show', $note->id) }}" class="link-dark rounded"><i class="lni lni-check-circle-1 fs-6 me-1 text-success"></i> {{ $note->name }}</a></li>    
                @endif
              @endforeach
            </ul>
          </div>
        </li>
      @endforeach
    </ul>
  </div>

  <!-- For mobile -->
  <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1" id="noteSidebar" aria-labelledby="noteSidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="noteSidebarLabel">
            <i class="fa-solid fa-list"></i> Navigation
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="list-unstyled ps-0">
        <li class="mb-1">
          <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#home-collapse_default" aria-expanded="true">
            Default
          </button>
          <div class="collapse show" id="home-collapse_default">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              @foreach ($service_notes as $note)
                @if ($note->category_id == null || $note->category_id == '')
                  <li><a href="{{ route('frontend.note.show', $note->id) }}" class="link-dark rounded"><i class="lni lni-check-circle-1 fs-6 me-1 text-success"></i> {{ $note->name }}</a></li>    
                @endif
              @endforeach
            </ul>
          </div>
        </li>
  
        @foreach ($service_note_categories as $category)
          <li class="mb-1">
            <div class="note-sidebar d-flex justify-content-between align-items-center position-relative group">
              <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#home-collapse_{{$category->id}}" aria-expanded="true">
                  {{ $category->name }}
              </button>
              <div class="edit-button" style="opacity: 0; transition: opacity 0.3s;">
                  <a class="btn btn-light border btn-sm px-1 p-0" href="{{ route('frontend.chapter.edit', $category->id) }}">
                      <i class="lni lni-pencil-1 fs-5"></i>
                  </a>
              </div>
            </div>
  
            <div class="collapse" id="home-collapse_{{$category->id}}">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                @foreach ($service_notes as $note)
                  @if ($category->id == $note->category_id)
                    <li><a href="{{ route('frontend.note.show', $note->id) }}" class="link-dark rounded"><i class="lni lni-check-circle-1 fs-6 me-1 text-success"></i> {{ $note->name }}</a></li>    
                  @endif
                @endforeach
              </ul>
            </div>
          </li>
        @endforeach
      </ul>
    </div>
</div>