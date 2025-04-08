<footer class="bg-gray-900 text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- About Section -->
        <div>
          <h5 class="text-xl font-semibold mb-3">About Us</h5>
          <p class="text-gray-400 text-sm">{{ app('settings')['site_description'] }}</p>
        </div>
  
        <!-- Social Media Links -->
        <div>
          <h5 class="text-xl font-semibold mb-3">Follow Us</h5>
          <div class="flex space-x-4 text-xl">
            <a href="{{ app('settings')['social_media_facebook_url'] }}" class="text-gray-400 hover:text-white">
              <i class="lni lni-facebook"></i>
            </a>
            <a href="{{ app('settings')['social_media_instagram_url'] }}" class="text-gray-400 hover:text-white">
              <i class="lni lni-instagram"></i>
            </a>
            <a href="{{ app('settings')['social_media_twitter_url'] }}" class="text-gray-400 hover:text-white">
              <i class="lni lni-x"></i>
            </a>
          </div>
        </div>
  
        <!-- Newsletter Subscription -->
        <div>
          <h5 class="text-xl font-semibold mb-3">Subscribe to Our Newsletter</h5>
          <span id="message" class="text-sm text-green-400"></span>
          <form class="flex flex-col sm:flex-row items-center gap-2 mt-3">
            <input type="email" id="email" placeholder="Enter your email" required
              class="w-full px-4 py-2 text-sm rounded-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="button" id="subscribe"
              class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition shadow-sm">
              Subscribe
            </button>
          </form>
        </div>
  
      </div>
    </div>
  </footer>
  

<script>
    document.getElementById('subscribe').addEventListener('click', () => {
        let email = document.getElementById('email');
        let message = document.getElementById('message');
        let route = {!! json_encode(route('frontend.subscribe')) !!};

        if (email.value.trim() === '') {
            message.textContent = "Email field is required";
            message.style.color = 'red';
            message.style.marginBottom = "10px";
            return;
        }

        const formData = new FormData();
        formData.append('email', email.value);
        formData.append('_token', '{{ csrf_token() }}');

        fetch(route, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                message.textContent = data.message;
                message.style.color = 'green';
            } else {
                message.textContent = data.message || "Subscription failed.";
                message.style.color = 'red';
            }
        })
        .catch(error => {
            message.textContent = "An error occurred. Please try again.";
            message.style.color = 'red';
            console.error("Error:", error);
        });
    });

</script>