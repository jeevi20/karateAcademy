<!DOCTYPE html>
<html lang="en">

<head>

<link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">



@include('layouts/admin/_meta')
@include('layouts/admin/_style')

</head>

<body style="background-color: #060b33;">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <!-- <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="first_name" class="form-control form-control-user"
                                            placeholder="First Name" value="{{ old('first_name') }}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="last_name" class="form-control form-control-user"
                                            placeholder="Last Name" value="{{ old('last_name') }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-user"
                                        placeholder="Email Address" value="{{ old('email') }}" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" class="form-control form-control-user"
                                            placeholder="Password" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="password_confirmation"
                                            class="form-control form-control-user" placeholder="Repeat Password"
                                            required>
                                    </div>
                                </div>
                                
                                
                            </form> -->
                            
                            <!-- 
                            <hr>
                            <div class="text-center">
                                <a class="small" href="#">Forgot Password?</a>
                            </div> -->

                            <img src="https://i.pinimg.com/originals/dc/bc/41/dcbc4126d9ee275bc2f87f8d3a581485.jpg" height= 100%;
                            width= 100%;>

                            <div class="text-center">
                                <a class="small" href="{{ route('login') }}"> Login </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('layouts/admin/_script')

</body>

</html>
