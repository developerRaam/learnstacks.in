@extends('admin.common.base')

@push('setTitle')
    Change Password
@endpush

@push('addScript')
    <script>
        const forgotPasswordBtn = document.getElementById('password_btn');
        forgotPasswordBtn.setAttribute('disabled', 'true'); 

        document.getElementById('password').addEventListener('input', function () {
            (this.value) ? forgotPasswordBtn.removeAttribute('disabled') : forgotPasswordBtn.setAttribute('disabled', 'true');
        });
    </script>
@endpush

@section('content')

<section class="container py-5 d-flex justify-content-center ">
    <div class="col-12 col-md-6">
       <div class="card shadow">
            <div class="card-body">
                <h4 class="text-center">Change Password</h4>
                <form action="{{$action}}" method="POST">
                    @csrf
                    <!-- password Input -->
                    <div class="mb-4">
                        <label for="password" class="form-label"><strong>New Password</strong></label>
                        <input type="password" class="form-control p-2 bg-light" id="password" name="password" placeholder="New Password">
                        <div class=mb-2>
                            <span class="text-danger">
                                @error('password')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                    </div>
            
                    <!-- password Input -->
                    <div class="mb-4">
                        <label for="confirm_password" class="form-label"><strong>Confirm Password</strong></label>
                        <input type="text" class="form-control p-2 bg-light" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                        <div class=mb-2>
                            <span class="text-danger">
                                @error('confirm_password')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                    </div>

                    @if(session('password_not_match'))
                        <div class="mb-4">
                            <span class="text-danger">
                            {{ session('password_not_match') }}
                            </span>
                        </div>
                    @endif
            
                    <!-- Submit Button -->
                    <div class="text-center">
                        <button class="btn btn-dark btn-lg px-5 py-2" id="password_btn" type="submit">Submit</button>
                    </div>
                </form>                
                
            </div>
       </div>
    </div>
</section>

@endsection