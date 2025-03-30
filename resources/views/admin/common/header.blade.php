<style>
  .dropdown-toggle::after{
    content: none !important;
  }
</style>
<header class="bg-light shadow" style="height: 5rem">
    <div class="d-flex justify-content-between align-items-center p-3">
        <h2>Learn Stacks</h2>
        <div class="d-flex">
            <div class="dropdown pe-3">
                <a class="dropdown-toggle fs-3 text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="background:transparent;">
                    @if (Auth::user()?->avatar)
                      <img src="{{ asset('storage') .'/'. Auth::user()?->avatar }}" alt="Learn Stacks" style="border-radius: 50%; width:50px; height:50px;margin-top:0px;">
                    @else 
                      <i class="fa-solid fa-user text-dark"></i>
                    @endif
               </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fa-solid fa-user"></i> Profile</a></li>
                  <li><a class="dropdown-item" href="{{ route('admin.changePassword') }}"><i class="fa-solid fa-key"></i> Change Password</a></li>
                  <li><a class="dropdown-item fs-6 text-danger" href="{{ route('admin.logout') }}"><i class="fa-solid fa-power-off"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>

<!-- Alert Message -->
@include('admin.common.alert')