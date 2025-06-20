<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts/admin/_meta')
    @include('layouts/admin/_style')
</head>

<body style="background-color: #060b33;">

    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">

        <!-- Card Container -->
        <div class="card o-hidden border-0 shadow-lg" style="width: 400px; background-color: #cfd5e3;">
            <div class="card-body p-4">

                <!-- Logo + Header -->
                <div class="text-center mb-3">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo" style="height: 80px; margin-bottom: 10px;">
                    <h1 class="h4 text-gray-900">Forgot Password?</h1>
                    <p class="text-muted small">
                        Enter your email and we’ll send you a password reset link.
                    </p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <input type="email" name="email" class="form-control form-control-user"
                               placeholder="Enter Email Address..." aria-label="Email" required autofocus>
                        @error('email')
                            <span class="text-danger small d-block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Email Password Reset Link
                    </button>
                </form>

                <hr>
                <div class="text-center">
                    <a class="small" href="{{ route('login') }}">Back to Login</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

