@extends('layouts.auth')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/core.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/icon-font.min.css') }}">
@endsection

@section('main')
<div class="login-header box-shadow">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="brand-logo">
            <a href="{{route('admin.login')}}" style="color: #323232;text-transform: capitalize">
                {{-- <img src="{{ asset('vendors/images/deskapp-logo.svg') }}" alt=""> --}}
                <img src="{{asset('vendors/images/logo/logo-dark.png')}}" alt="" class="light-logo mr-2" width="50px" height="50px" >

                <span style="text-transform: capitalize">SneakersBuy</span>
            </a>
        </div>
        {{-- <div class="login-menu">
            <ul>
                <li><a href="{{route('admin.login')}}">Login</a></li>
        </ul>
    </div> --}}
</div>
</div>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif



<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-7">
                <img src="{{ asset('vendors/images/login-page-img.png') }}" alt="">
            </div>


            <div class="col-md-6 col-lg-5">
                <div class="login-box bg-white box-shadow border-radius-10">
                    <div class="login-title">
                        <h2 class="text-center text-primary">Reset Password</h2>
                    </div>
                    <form method="POST" action="{{ route('admin.reset-password-success') }}">
                        @csrf

                        {{-- <div class="form-group">
                            <label for="password" class="col-form-label pr-2">Password:</label>
                            <div class="input-group custom">
                                <input type="password" class="form-control form-control-lg" id="newpassword" name="password" placeholder="**********" required>
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="fas fa-eye-slash" id="toggleNewPassword" style="cursor: pointer;"></i></span>


                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="col-form-label pr-2">Confirm Password:</label>
                            <div class="input-group custom">
                                <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" placeholder="**********" required>
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="fas fa-eye-slash" id="toggleConfirmNewPassword" style="cursor: pointer;"></i></span>


                                </div>
                            </div>
                        </div> --}}
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="form-group">
                            <label for="newPassword" class="col-form-label pr-2">Password:</label>
                            <div class="input-group custom">
                                <input type="password" class="form-control form-control-lg" id="newPassword" name="password" placeholder="**********" required>
                                <div class="input-group-append custom">
                                    <span class="input-group-text">
                                        <i class="fas fa-eye-slash" id="toggleNewPassword" style="cursor: pointer;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="col-form-label pr-2">Confirm Password:</label>
                            <div class="input-group custom">
                                <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" placeholder="**********" required>
                                <div class="input-group-append custom">
                                    <span class="input-group-text">
                                        <i class="fas fa-eye-slash" id="toggleConfirmNewPassword" style="cursor: pointer;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group mb-0">
                                    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Reset Password">
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('src/plugins/jquery-steps/jquery.steps.js') }}"></script>
<script src="{{ asset('vendors/scripts/steps-setting.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function setupPasswordToggle(toggleId, passwordId) {
            const togglePassword = document.getElementById(toggleId);
            const passwordInput = document.getElementById(passwordId);

            if (togglePassword && passwordInput) { // Ensure elements exist
                togglePassword.addEventListener('click', function() {
                    // Toggle the type attribute
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle the eye slash icon
                    this.classList.toggle('fa-eye-slash');
                    this.classList.toggle('fa-eye');
                });
            }
        }

        // Setup toggles for each password input
        setupPasswordToggle('toggleNewPassword', 'newPassword');
        setupPasswordToggle('toggleConfirmNewPassword', 'password_confirmation');
    });

</script>

@endsection
