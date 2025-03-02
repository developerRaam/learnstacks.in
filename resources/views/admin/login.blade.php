@extends('admin.common.base')

@push('setTitle')
   Admin Login
@endpush

@push('addStyle')
    <style>
        .login-form-wrapper {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .login_heading {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .login-input,
        .login_btn {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .login_btn {
            background-color: #000;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login_btn:hover {
            background-color: #000000da;
        }

    </style>
@endpush

@push('addScript')
    <script>
        // setup remember me
        function setCookies(){
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;

            const baseURL = `${window.location.origin}`; // Get base URL dynamically
            const path = `${baseURL}/admin/login`;

            document.cookie="myEmail="+email+";path="+path;
            document.cookie="myPassword="+password+";path="+path;
        }

        window.addEventListener('load', function() {
            getCookiesData();
        });

        function getCookiesData(){
            let getEmail = getCookie('myEmail');
            let getPassword = getCookie('myPassword');

            document.getElementById('email').value = getEmail;
            document.getElementById('password').value = getPassword;
        }

        function getCookie(cname) {
            let name = cname + "=";
            let ca = document.cookie.split(';');
            for(let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        // remove header 
        document.querySelector('header').remove()
    </script>
@endpush

@section('content')

<section class="container py-5 d-flex justify-content-center align-items-center" style="width: 100vh; height:100vh">
    <div class="login-form-wrapper">

        <div class="login-form-container active" id="loginForm">
            <h2 class="login_heading">Login</h2>
            <!-- alert message -->
            @include('admin.common.alert')
            <form action="{{ $action }}" method="post">
                @csrf
                <input type="email" class="login-input" name="email" id="email" placeholder="Email" required>
                <input type="password" class="login-input" name="password" id="password" placeholder="Password" required>
                <div class="form-check py-2">
                    <input class="form-check-input" type="checkbox" name="remember_me" id="remember_me" onclick="setCookies()">
                    <label class="form-check-label" for="remember_me">
                      Remember Me
                    </label>
                  </div>
                <button type="submit" class="login_btn">Login</button>
                {{-- <a href="{{ $route_forgot }}" class="text-decoration-none">Forgot Password</a> --}}
            </form>
        </div>
        
    </div>
</section>

@endsection