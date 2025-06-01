@extends('frontend.common.base')
@push('setTitle') Remove Background @endpush

@push('addTitle'){{ 'Convert Remove Background' }}@endpush
@push('addDescription'){{ 'Compress images online without losing quality. Use our free Image Compressor to reduce JPG or PNG file size instantly. Fast, secure, and optimized for web.' }}@endpush
@push('addKeywords'){{'image compressor, compress image online, jpg compressor, png compressor, reduce image size, compress image without losing quality, image optimization tool, free image compressor, online image size reducer, fast image compression'}}@endpush
@push('addRobots'){{ 'index,follow' }}@endpush
@push('addGooglebot'){{ 'index,follow' }}@endpush

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl p-6">

            <h2 class="text-3xl font-bold mb-6 text-gray-800 text-center">Remove Background</h2>
            <div class="flex grid-cols-1 lg:grid-cols-2 justify-center gap-5">
                <div class="bg-slate-100 p-8 rounded-2xl border w-full max-w-xl mx-auto">
                
                    <div id="messageBox" class="mb-4 p-4 bg-red-100 rounded-lg hidden">
                        <p class="mb-0" id="message"></p>
                    </div>
                
                    <form class="space-y-6">
                        @csrf
                        <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Choose Image</label>
                            <input type="file" id="image" onchange="previewImage(event)" 
                                class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                                accept="image/*">
                        </div>
                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="button" id="submitBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-3 rounded-lg transition duration-200">
                                Remove
                            </button>
                        </div>
                    </form>
                </div>

                <div id="imagePreviewDiv" class="bg-slate-100 p-8 rounded-2xl border w-full max-w-xl mx-auto hidden">
                    <img alt="Image Preview" id="imagePreview" class="w-full rounded-lg border border-gray-300" style="aspect-ratio: 1 / 1; object-fit: cover;">
                    <p id="imageSize" class="mt-2 text-sm text-gray-500 hidden"></p>
                </div>
            </div>

            <!-- Result Display -->
            <div id="displayBox" class="mt-8 p-6 bg-green-50 border border-green-300 text-green-800 hidden rounded-lg">
                <div class="flex grid-cols-3 justify-between items-center gap-5">
                    <img src="" id="imagePath" class="w-32 h-auto rounded shadow">
                    <p id="convertImageSize" class="text-sm text-gray-500 hidden"></p>
                    <a href="" id="imageUrl" class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition duration-200" download>
                        ⬇️ Download Image
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('addScript')
    <script>
        // Preview image
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const image = new Image();
                    image.src = e.target.result;
                    image.onload = function(e) {
        
                        document.getElementById('imagePreviewDiv').classList.remove('hidden');
                        document.getElementById('imagePreview').src = image.src;
                        
                        // get image size
                        const sizeInBytes = file.size;
                        let displaySize = '';
                        if (sizeInBytes >= 1024 * 1024) {
                            const sizeInMB = (sizeInBytes / (1024 * 1024)).toFixed(2);
                            displaySize = `${sizeInMB} MB`;
                        } else {
                            const sizeInKB = (sizeInBytes / 1024).toFixed(2);
                            displaySize = `${sizeInKB} KB`;
                        }
                        document.getElementById('imageSize').textContent = `Image size: ${displaySize}`;
                    }
                }

                reader.readAsDataURL(file);
            }
        }

        // submit
        document.getElementById('submitBtn').addEventListener('click', (e) => {
            e.preventDefault();
            const image = document.getElementById('image');
            const message = document.getElementById('message');
            const messageBox = document.getElementById('messageBox');
            let route = {!! json_encode(route('tools.removeBackground')) !!};

            messageBox.classList.remove('hidden');
            message.style.color = 'red';

            if (image?.files?.length === 0) {
                message.textContent = "Image field is required";
                return;
            }

            // Hide message box for new request
            messageBox.classList.add('hidden');
            
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.textContent = 'Processing...';
            submitBtn.disabled = true;

            const formData = new FormData();
            formData.append('image', image.files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            fetch(route, {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                messageBox.classList.remove('hidden');
                submitBtn.textContent = 'Remove';
                submitBtn.disabled = false;
                
                if (data.success) {
                    message.textContent = data.message;
                    message.style.color = 'green';
                    messageBox.classList.remove('bg-red-100')
                    messageBox.classList.add('bg-green-100')

                    // show image
                    document.getElementById('displayBox').classList.remove('hidden');
                    document.getElementById('imagePath').src = data.path;
                    document.getElementById('imageUrl').href = data.path;
                    document.getElementById('convertImageSize').textContent = 'Image Size: ' + data.size
                } else {
                    message.textContent = 'Something went wrong';
                }
            })
            .catch(error => {
                message.textContent = "An error occurred. Please try again.";
                message.style.color = 'red';
                console.error("Error:", error);
            });
        });
    </script>
@endpush