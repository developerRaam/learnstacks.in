<aside class="left-sidebar">
    <div style="max-height: 100%; height:90vh">
        <ul class="list-unstyled">
            <li class="py-2"><strong class="text-white"><i class="fa-solid fa-bars"></i> Navigation</strong></li>
            <li><a class="text-decoration-none text-white d-block" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            @can('view_user')
                <li><a class="text-decoration-none text-white d-block" href="{{ route('admin.user') }}"><i class="fa-solid fa-user"></i> User</a></li>
            @endcan

            @can('view_category')
                <li><a class="text-decoration-none text-white d-block" href="{{ route('admin.category') }}"><i class="fa-solid fa-user"></i> Category</a></li>
            @endcan

            @can('view_banner')
                <li><a class="text-decoration-none text-white d-block" href="{{ route('admin.banner') }}"><i class="fa-solid fa-photo-film"></i> Banner</a></li>
            @endcan

            @can('view_post')
                <li><a class="text-decoration-none text-white d-block" href="{{ route('admin.posts') }}"><i class="fa-solid fa-blog"></i> Posts</a></li>
            @endcan

            @can('view_page')
                <li><a class="text-decoration-none text-white d-block" href="{{ route('admin.pages') }}"><i class="fa-solid fa-pager"></i> Pages</a></li>
            @endcan

            <li><a class="text-decoration-none text-white d-block" href="{{ route('admin.media') }}"><i class="fa-solid fa-film"></i> Media</a></li>
            
            @can('view_subscriber')
                <li><a class="text-decoration-none text-white d-block" href="{{ route('admin.subscriber') }}"><i class="fa-solid fa-users"></i> Subscriber</a></li>
            @endcan

            @can('view_subscriber')
                <li><a class="text-decoration-none text-white d-block" href="{{ route('admin.viewPermission') }}"><i class="fa-solid fa-lock"></i> Permission</a></li>
            @endcan

            @can('edit_setting')
                <li><a class="text-decoration-none text-white d-block" href="{{ route('admin.setting') }}"><i class="fa-solid fa-gear"></i> Settings</a></li>
            @endcan
        </ul>
    </div>
</aside>