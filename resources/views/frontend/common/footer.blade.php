<!-- Footer Section -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- About Section -->
            <div class="col-md-4 mb-4">
                <h5>About Us</h5>
                <p>{{ app('settings')['site_description'] }}</p>
            </div>

            <!-- Social Media Links -->
            <div class="col-md-4 mb-4">
                <h5>Follow Us</h5>
                <div class="social-icons">
                    <a href="{{ app('settings')['social_media_facebook_url'] }}" class="lni lni-facebook"></a>
                    <a href="{{ app('settings')['social_media_instagram_url'] }}" class="lni lni-instagram"></a>
                    <a href="{{ app('settings')['social_media_twitter_url'] }}" class="lni lni-x"></a>
                </div>
            </div>

            <!-- Newsletter Subscription -->
            <div class="col-md-4 mb-4">
                <h5>Subscribe to Our Newsletter</h5>
                <span id="message"></span>
                <div class="newsletter d-flex">
                    <input type="email" id="email" placeholder="Enter your email" required>
                    <button class="shodow-sm" type="button" id="subscribe">Subscribe</button>
                </div>
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