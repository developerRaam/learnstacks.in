<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
    <title>@stack('setTitle')</title>
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">

    <!-- Add additional css link -->
    @stack('addStyle')
    <link rel="icon" href="{{ asset('logo.jpg') }}" type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- summernote -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>

    <!-- Sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body style="background:#f4f4f4;overflow-x:hidden">

    @include('admin.common.header')

    @yield('content')

    @include('admin.common.footer')

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sweet alert -->
    <script src="{{ URL::asset('admin/js/sweet-alert.js')}}"></script>
    
    <!-- Add additional js link -->
    @stack('addScript')
    
    <script>
        // for tooltip
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        // start summernote 
        $(document).ready(function() {
            $('#summernote').summernote({
            height: 300,
            toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica Neue', 'Helvetica', 'Impact', 'Lucida Grande', 'Tahoma', 'Times New Roman', 'Verdana'],
                fontNamesIgnoreCheck: ['Helvetica Neue', 'Helvetica', 'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Impact', 'Lucida Grande', 'Tahoma', 'Times New Roman', 'Verdana'],
            });
            
            // upload images
            $('#summernote').on('summernote.image.upload', function(we, files) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#summernote').summernote('insertImage', e.target.result, function($image) {
                        $image.css('display', 'block').css('margin', '0 auto');
                    });
                };
                reader.readAsDataURL(files[0]);
            });
            
            // toggle
            $(document).on('click', '.note-toolbar .dropdown-toggle', function(e) {
                e.preventDefault(); // Prevent default action
                e.stopPropagation(); // Stop event propagation

                // Initialize Bootstrap 5 dropdown manually
                let dropdown = bootstrap.Dropdown.getInstance(this) || new bootstrap.Dropdown(this);
                dropdown.toggle();
            });

            $(document).on('click', function() {
                $('.note-dropdown-menu.show').removeClass('show');
            });
        });
        // end summernote
    </script>
</body>
</html>