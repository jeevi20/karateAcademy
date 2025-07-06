<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts/admin/_meta')
    @include('layouts/admin/_style')
</head>

<body style="background-color: #060b33;">

    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">

        <div class="card o-hidden border-0 shadow-lg" style="width: 400px; background-color: #cfd5e3;">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo" style="height: 80px; margin-bottom: 10px;">
                    <h1 class="h4 text-gray-900">Welcome Back!</h1>
                </div>

                <form class="user" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <input type="email" name="email" class="form-control form-control-user"
                            placeholder="Enter Email Address..." required value="{{ old('email') }}">
                        @error('email')
                            <div class="text-danger mt-1" style="font-size: 14px;">{!! $message !!}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="password" name="password" class="form-control form-control-user"
                            placeholder="Password" required>
                        @error('password')
                            <div class="text-danger mt-1" style="font-size: 14px;">{!! $message !!}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" name="remember" class="custom-control-input" id="customCheck">
                            <label class="custom-control-label" for="customCheck">Remember Me</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Login
                    </button>
                </form>

                <hr>
                <div class="text-center">
                    <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                </div>

            </div>
        </div>
    </div>

</body>

</html>
