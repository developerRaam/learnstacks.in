<aside class="left-sidebar">
    <div style="max-height: 100%; height:90vh">
        <ul class="list-unstyled">
            <li class="py-2"><strong class="text-white"><i class="fa-solid fa-bars"></i> Navigation</strong></li>
            <li><a class="text-decoration-none text-white d-block" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            <li><a class="text-decoration-none text-white d-block" href="{{ route('admin.user') }}"><i class="fa-solid fa-user"></i> User</a></li>
            <li><a class="text-decoration-none text-white d-block" href="{{ route('admin.banner') }}"><i class="fa-solid fa-photo-film"></i> Banner</a></li>
        </ul>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var dropdowns = document.querySelectorAll('.dropdown-btn');

        dropdowns.forEach(function (dropdown) {
            var dropdownId = dropdown.dataset.dropdown;
            var dropdownContent = document.getElementById('dropdown-' + dropdownId);

            if (localStorage.getItem('dropdown-' + dropdownId) === 'true') {
                dropdown.classList.add('active');
                dropdownContent.style.display = 'block';
                dropdownContent.style.maxHeight = dropdownContent.scrollHeight + "px";
            }

            dropdown.addEventListener('click', function () {
                var isOpen = dropdownContent.style.maxHeight;
                if (isOpen) {
                    dropdownContent.style.maxHeight = null;
                    dropdownContent.style.display = 'none';
                    dropdown.classList.remove('active');
                    localStorage.setItem('dropdown-' + dropdownId, 'false');
                } else {
                    dropdownContent.style.display = 'block';
                    dropdownContent.style.maxHeight = dropdownContent.scrollHeight + "px";
                    dropdown.classList.add('active');
                    localStorage.setItem('dropdown-' + dropdownId, 'true');
                }
            });
        });
    });
</script>