@extends('admin.common.base')

@push('setTitle')
    Verify OTP
@endpush

@push('addScript')
    <script>
        const forgotPasswordBtn = document.getElementById('verify_otp_btn');
        forgotPasswordBtn.setAttribute('disabled', 'true'); 

        document.getElementById('otp').addEventListener('input', function () {
            (this.value) ? forgotPasswordBtn.removeAttribute('disabled') : forgotPasswordBtn.setAttribute('disabled', 'true');
        });
    </script>
@endpush

@section('content')

<section class="container py-5 d-flex justify-content-center ">
    <div class="col-12 col-md-6">
       <div class="card shadow">
            <div class="card-body">
                <h4 class="text-center">Verify OTP</h4>

                <!-- alert message -->
                @include('admin.common.alert')

                <form action="{{$action}}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <div class="text-start mb-2">
                            <label for="otp"><strong>Enter OTP</strong></label>
                        </div>
                        <div class="mb-3">
                            <input type="text" id="otp" name="otp" class="form-control p-2" placeholder="Enter OTP">
                        </div>
                        <div class=mb-2>
                            <span class="text-danger">
                                @error('otp')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        <div>
                            <button class="btn btn-dark" id="verify_otp_btn" type="submit">Verify</button>
                        </div>
                    </div>
                </form>
                
            </div>
       </div>
    </div>
</section>

@endsection